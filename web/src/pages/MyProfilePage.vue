<template>
  <q-page
    padding
    class="column items-center"
  >
    <CardProfile
      id="1"
      :edit-mode="isEditMode"
      class="myprofile-card"
    />

    <q-page-sticky
      position="bottom-right"
      class="q-pa-lg"
    >
      <q-fab
        v-model="isShowFab"
        icon="keyboard_arrow_up"
        color="primary"
        direction="up"
        @before-hide="isShowFab = isEditMode"
      >
        <template v-if="isEditMode">
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
          @click="isEditMode = true"
        />
      </q-fab>
    </q-page-sticky>
  </q-page>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import CardProfile from 'components/CardProfile.vue';

const isEditMode = ref(false);
const isShowFab = ref(true);

const onSaveChanges = () => {
  isEditMode.value = false;
  // TODO: save changes
};

const onCancelChanges = () => {
  isEditMode.value = false;
  // TODO: revert changes
};
</script>

<style lang="sass">
.myprofile-card
  width: 100vmin
</style>
