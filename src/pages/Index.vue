<template>
  <q-page
    padding
    class="column q-gutter-md"
  >
    <q-input
      v-model="search"
      label="Cari disini..."
      dense
    >
      <template #append>
        <q-icon name="search" />
      </template>
    </q-input>

    <list-table-member
      :data="data"
      :filter="search"
      :loading="isLoading"
    >
      <template #action="{ data }">
        <q-btn
          label="Detail"
          color="secondary"
          flat
          @click="() => onDetailClick(data)"
        />
      </template>
    </list-table-member>
  </q-page>

  <q-dialog v-model="isDialogOpen">
    <card-profile
      :data="currentCardProfile"
      class="profile-card q-py-md"
    />
  </q-dialog>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import ListTableMember from 'src/components/ListTableMember.vue';
import { useCollection } from 'src/use/firestore';
import { collections, memberMergeDefaults } from 'src/firestoreServices';
import CardProfile from 'src/components/CardProfile.vue';
import type { Member } from 'app/common/schema';

export default defineComponent({
  name: 'PageIndex',

  components: { ListTableMember, CardProfile },

  setup() {
    const state = reactive({
      search: '',
      currentCardProfile: null as (Member | null),
      isDialogOpen: false,
    });
    const { data, isLoading } = useCollection(collections.Members);

    return {
      ...toRefs(state),
      data,
      isLoading,
    };
  },
  methods: {
    onDetailClick(member: Partial<Member>) {
      this.currentCardProfile = memberMergeDefaults(member);
      this.isDialogOpen = true;
    },
  },
});
</script>

<style lang="sass" scoped>
.profile-card
  width: 100vmin
  max-width: $breakpoint-xs
  max-width: $breakpoint-sm
</style>
