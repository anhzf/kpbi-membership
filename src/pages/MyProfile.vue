<template>
  <q-page
    padding
    class="column items-center"
  >
    <CardProfile
      v-model:data="data"
      :edit-mode="editMode"
      class="myprofile-card min-w-xs max-w-sm"
    />
    <q-page-sticky
      position="bottom-right"
      class="q-pa-lg"
    >
      <q-fab
        v-model="showFab"
        icon="keyboard_arrow_up"
        color="primary"
        direction="up"
        @before-hide="showFab = editMode"
      >
        <template v-if="editMode">
          <q-fab-action
            label="Batalkan perubahan"
            icon="delete_forever"
            color="negative"
            external-label
            label-position="left"
            @click="onCancelChanges"
          />
          <q-fab-action
            label="Simpan perubahan"
            icon="save"
            color="positive"
            external-label
            label-position="left"
            @click="onSaveChanges"
          />
        </template>

        <q-fab-action
          v-else
          label="Perbarui profil"
          icon="edit"
          color="info"
          external-label
          label-position="left"
          @click="editMode = true"
        />
      </q-fab>
    </q-page-sticky>
  </q-page>
</template>

<script lang="ts">
import {
  defineComponent, ref, computed, watch,
} from 'vue';
import { Loading, Notify } from 'quasar';
import CardProfile from 'src/components/CardProfile.vue';
import { collections, factories, memberMergeDefaults } from 'src/firestoreServices';
import { useStore } from 'src/store';
import { useDoc } from 'src/use/firestore';
import { getErrMsg } from 'src/helpers';

export default defineComponent({
  name: 'PageMyProfile',
  components: {
    CardProfile,
  },
  setup() {
    const store = useStore();
    const memberDocRef = computed(() => collections.Members.doc(store.state.auth.user?.uid));
    const { data, update } = useDoc(memberDocRef);
    const editableData = ref(memberMergeDefaults(data.value ?? {}));
    const assignDataOri = () => {
      editableData.value = memberMergeDefaults(data.value ?? {});
    };
    const commitChanges = () => memberDocRef.value
      .update({
        ...editableData.value,
        ...factories.attrs.update(),
      })
      .then(() => update());

    watch(data, () => assignDataOri(), { immediate: true });

    return {
      data: editableData,
      assignDataOri,
      commitChanges,
    };
  },
  data() {
    return {
      editMode: false,
      showFab: true,
    };
  },
  methods: {
    onCancelChanges() {
      this.editMode = false;
      this.assignDataOri();
    },
    onSaveChanges() {
      this.editMode = false;
      Loading.show();
      this.commitChanges()
        .then(() => Notify.create('Profil berhasil diperbarui!'))
        .catch((err) => Notify.create({ message: getErrMsg(err), type: 'negative' }))
        .finally(() => Loading.hide());
    },
  },
});
</script>

<style lang="sass">
.myprofile-card
  width: 100vmin
</style>
