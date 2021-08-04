<template>
  <q-page
    padding
    class="column items-center"
  >
    <card-profile
      ref="cardProfile"
      v-model:data="data"
      :edit-mode="editMode"
      :pt-img-src="pTPhotoUrl"
      :kaprodi-img-src="kaprodiPhotoUrl"
      class="myprofile-card min-w-xs max-w-sm"
      @selectPTImg="onSelectPTImg"
      @selectKaprodiImg="onSelectKaprodiImg"
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
  defineComponent, ref, reactive, computed, watch,
} from 'vue';
import { Notify } from 'quasar';
import { asyncComputed } from '@vueuse/core';
import CardProfile from 'src/components/CardProfile.vue';
import { collections, memberMergeDefaults } from 'src/firestoreServices';
import { useStore } from 'src/store';
import { useDoc } from 'src/use/firestore';
import ProfileUseCase from 'src/useCases/profile';
import { promiseProxy } from 'src/helpers';

export default defineComponent({
  name: 'PageMyProfile',
  components: {
    CardProfile,
  },
  setup() {
    const store = useStore();
    const memberDocRef = computed(() => collections.Members.doc(store.state.auth.user?.uid));
    const { data, update } = useDoc(memberDocRef);
    const profileUseCase = computed(() => new ProfileUseCase(memberDocRef.value));
    const editableData = ref(memberMergeDefaults(data.value ?? {}));
    const uploadedPhotoTemp = reactive({
      PT: undefined as (File | undefined),
      kaprodi: undefined as (File | undefined),
    });
    const assignDataOri = () => {
      editableData.value = memberMergeDefaults(data.value ?? {});
    };
    const commitChanges = promiseProxy(() => Promise.all([
      profileUseCase.value.update(editableData.value),
      uploadedPhotoTemp.PT && profileUseCase.value.updatePTPhoto(uploadedPhotoTemp.PT),
      uploadedPhotoTemp.kaprodi && profileUseCase.value.updateKaprodiPhoto(uploadedPhotoTemp.kaprodi),
    ] as const)
      .then(update));
    const pTPhotoUrl = asyncComputed(promiseProxy(() => profileUseCase.value.getPTPhoto()), undefined);
    const kaprodiPhotoUrl = asyncComputed(promiseProxy(() => profileUseCase.value.getKaprodiPhoto()), undefined);

    watch(data, assignDataOri, { immediate: true });

    return {
      data: editableData,
      uploadedPhotoTemp,
      profileUseCase,
      pTPhotoUrl,
      kaprodiPhotoUrl,
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
      // eslint-disable-next-line @typescript-eslint/no-unsafe-member-access, @typescript-eslint/no-unsafe-call
      (this.$refs?.cardProfile as InstanceType<typeof CardProfile>)
        .resetUploadedImg();
    },
    onSaveChanges() {
      /* TODO: add form validation */
      this.editMode = false;
      void this.commitChanges()
        .then(() => Notify.create('Profil berhasil diperbarui!'));
    },
    onSelectPTImg(file: File) {
      this.uploadedPhotoTemp.PT = file;
    },
    onSelectKaprodiImg(file: File) {
      this.uploadedPhotoTemp.kaprodi = file;
    },
  },
});
</script>

<style lang="sass">
.myprofile-card
  width: 100vmin
</style>
