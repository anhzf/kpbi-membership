<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import CardHeader from 'components/MemberProfile/CardHeader.vue';
import CollegeCard from 'components/MemberProfile/CollegeCard.vue';
import HeadOfProgramCard from 'components/MemberProfile/HeadOfProgramCard.vue';
import ProgramCard from 'components/MemberProfile/ProgramCard.vue';
import DefineState from 'components/DefineState.vue';
import memberService from 'src/services/member';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const isOwner = computed(() => route.params.memberId === 'me');
const {
  state: data, isLoading, execute: refresh,
} = useAsyncState(() => memberService.get(String(route.params.memberId)), undefined);
</script>

<template>
  <q-page
    padding
    class="column"
  >
    <q-btn
      v-if="!isOwner"
      icon="arrow_back"
      flat
      round
      class="self-start"
      @click="$router.back"
    />

    <q-card
      v-if="data"
      flat
      square
      class="self-center items-start w-full max-w-screen-lg"
    >
      <define-state
        :value="data.period_end > new Date()"
        #="{states: [isVerified]}"
      >
        <div :class="['text-center py-.5 mb-1 text-white', isVerified ? 'bg-positive' : 'bg-negative']">
          {{ isVerified
            ? `Terverifikasi sampai ${data.period_end.toLocaleString('id', {dateStyle: 'short'})}`
            : 'Belum Terverifikasi' }}
        </div>
      </define-state>

      <q-card-section>
        <card-header
          :edit-mode="isOwner"
          :college-img="data.college.img_url"
          :degree="data.education_program.degree"
          :college-name="data.college.name"
          :college-short-name="data.college.short_name"
          :faculty="data.education_program.faculty"
          :department="data.education_program.department"
          :program-name="data.education_program.name"
        />
      </q-card-section>

      <q-card-section class="row q-col-gutter-sm">
        <div class="col-6 column q-col-gutter-sm">
          <div>
            <program-card
              :data="data.education_program"
              @updated="refresh"
            />
          </div>

          <div>
            <head-of-program-card
              :data="data.responsible"
            />
          </div>
        </div>

        <div class="col-6 column q-col-gutter-sm">
          <div>
            <college-card
              :data="data.college"
              @updated="refresh"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <q-inner-loading :showing="isLoading" />
  </q-page>
</template>
