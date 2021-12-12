<template>
  <q-page
    padding
    class="column q-gutter-md"
  >
    <q-input
      v-model="search"
      label="Cari disini..."
      dense
      outlined
    >
      <template #append>
        <q-icon name="search" />
      </template>
    </q-input>

    <table-member-list
      :data="members"
      :filter="search"
      :loading="isLoading"
    >
      <template #action="{ data }">
        <q-btn
          label="Detail"
          color="secondary"
          flat
          @click="onDetailClick(data.value)"
        />
      </template>
    </table-member-list>
  </q-page>

  <q-dialog v-model="isCardProfileDialogOpen">
    <card-profile
      :id="currentCardProfile"
      class="profile-card q-py-md"
    />
  </q-dialog>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted } from 'vue';
import TableMemberList from 'components/TableMemberList.vue';
import CardProfile from 'components/CardProfile.vue';
import * as mocks from 'src/mocks';

const search = ref('');
const members = ref(mocks.members);
const isLoading = ref(true);
const currentCardProfile = ref('');
const isCardProfileDialogOpen = computed({
  get: () => Boolean(currentCardProfile.value),
  set: (value) => {
    if (!value) {
      currentCardProfile.value = '';
    }
  },
});

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false;
  }, 2000);
});

const onDetailClick = (id: string) => {
  currentCardProfile.value = id;
};
</script>

<style lang="sass" scoped>
.profile-card
  width: 100vmin
  max-width: $breakpoint-xs
  max-width: $breakpoint-sm
</style>
