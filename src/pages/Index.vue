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
      :pt-img-src="pTPhotoUrl"
      :kaprodi-img-src="kaprodiPhotoUrl"
      class="profile-card q-py-md"
    />
  </q-dialog>
</template>

<script lang="ts">
import {
  defineComponent, reactive, computed, toRefs,
} from 'vue';
import { useAsyncState, asyncComputed } from '@vueuse/core';
import ListTableMember from 'src/components/ListTableMember.vue';
import CardProfile from 'src/components/CardProfile.vue';
import { useCollection } from 'src/use/firestore';
import {
  collections, jsonDateToTimestamp, memberMergeDefaults,
} from 'src/firestoreServices';
import ProfileUseCase from 'src/useCases/profile';
import { promiseProxy } from 'src/helpers';
import type { Member, Model, ModelInObject } from 'app/common/schema';
import type { LegacyProfile } from 'app/common/legacy';

type ModelObject = ModelInObject<Model<Member>> & ({
  _isLegacy: true;
  _kaprodiImgSrc: string;
  _pTImgSrc: string;
} | {
  _isLegacy?: false;
});

export default defineComponent({
  name: 'PageIndex',
  components: { ListTableMember, CardProfile },
  setup() {
    const state = reactive({
      search: '',
      currentCardProfile: null as (ModelObject | null),
      isDialogOpen: false,
    });
    const { data, isLoading } = useCollection(collections.Members);
    const profileUseCase = computed(() => {
      if (state.currentCardProfile) {
        const docRef = collections.Members.doc(state.currentCardProfile._uid);
        return new ProfileUseCase(docRef);
      }

      return null;
    });
    const { state: oldData, isReady } = useAsyncState(async () => {
      const res = await fetch('https://anggota.kpbi.or.id/api/kpbi/profiles');
      const profiles = await res.json() as LegacyProfile[];

      return profiles.map((profile) => ({
        _uid: profile.id.toString(),
        _updated: jsonDateToTimestamp(profile.updated_at),
        _created: jsonDateToTimestamp(profile.created_at),
        _deleted: null,
        ...ProfileUseCase.legacyProfileConverter(profile),
      }) as ModelObject);
    }, []);
    const mergedData = computed<ModelObject[]>(() => [
      ...data.value,
      ...oldData.value.filter((el) => data.value
        .findIndex((newEl) => newEl.emailProdi === el.emailProdi)),
    ]);
    const pTPhotoUrl = asyncComputed(promiseProxy(() => Promise
      .resolve(state.currentCardProfile?._isLegacy
        ? `https://anggota.kpbi.or.id/${state.currentCardProfile._pTImgSrc}`
        : profileUseCase.value?.getPTPhoto())), undefined);
    const kaprodiPhotoUrl = asyncComputed(promiseProxy(() => Promise
      .resolve(state.currentCardProfile?._isLegacy
        ? `https://anggota.kpbi.or.id/${state.currentCardProfile._kaprodiImgSrc}`
        : profileUseCase.value?.getKaprodiPhoto())), undefined);

    return {
      ...toRefs(state),
      data: mergedData,
      pTPhotoUrl,
      kaprodiPhotoUrl,
      isLoading: computed(() => isLoading.value && isReady.value),
    };
  },
  methods: {
    onDetailClick(member: Partial<ModelObject>) {
      this.currentCardProfile = memberMergeDefaults(member) as ModelObject;
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
