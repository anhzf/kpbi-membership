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
import {
  defineComponent, reactive, computed, toRefs,
} from 'vue';
import { useAsyncState } from '@vueuse/core';
import ListTableMember from 'src/components/ListTableMember.vue';
import { useCollection } from 'src/use/firestore';
import { collections, jsonDateToTimestamp, memberMergeDefaults } from 'src/firestoreServices';
import CardProfile from 'src/components/CardProfile.vue';
import type { Member, Model, ModelInObject } from 'app/common/schema';
import type { LegacyProfile } from 'app/common/legacy';
import ProfileUseCase from 'src/useCases/profile';

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
    const { state: oldData, isReady } = useAsyncState(async () => {
      const res = await fetch('https://anggota.kpbi.or.id/api/kpbi/profiles');
      const profiles = await res.json() as LegacyProfile[];

      return profiles.map((profile) => ({
        _uid: profile.id.toString(),
        _updated: jsonDateToTimestamp(profile.updated_at),
        _created: jsonDateToTimestamp(profile.created_at),
        _deleted: null,
        ...ProfileUseCase.legacyProfileConverter(profile),
      }) as ModelInObject<Model<Member>>);
    }, []);
    const mergedData = computed<ModelInObject<Model<Member>>[]>(() => [
      ...data.value,
      ...oldData.value.filter((el) => data.value
        .findIndex((newEl) => newEl.emailProdi === el.emailProdi)),
    ]);

    return {
      ...toRefs(state),
      data: mergedData,
      isLoading: computed(() => isLoading.value && isReady.value),
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
