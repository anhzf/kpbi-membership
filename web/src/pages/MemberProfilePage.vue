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
const { state: data, isLoading } = useAsyncState(() => memberService.get(String(route.params.memberId)), undefined);
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
        #="{state: isVerified}"
      >
        <div :class="['text-center py-.5 mb-1 text-white', isVerified ? 'bg-positive' : 'bg-negative']">
          {{ isVerified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
        </div>
      </define-state>

      <q-card-section>
        <card-header
          :college-img="data.college.img"
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
              :accreditations="data.education_program.accreditations"
              :email="data.education_program.email"
              :phone-number="data.education_program.phone_number"
              :external-link="data.education_program.external_link"
            />
          </div>

          <div>
            <head-of-program-card
              :img="data.responsible.user.img"
              :name="data.responsible.user.name"
              :email="data.responsible.user.email"
              :phone-number="data.responsible.user.phone_number"
            />
          </div>
        </div>

        <div class="col-6 column q-col-gutter-sm">
          <div>
            <college-card
              :accreditations="data.college.accreditations"
              :street-address="data.college.street_address"
              :city="data.college.city"
              :province="data.college.province"
              :kind="data.college.type"
            />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <q-inner-loading :showing="isLoading" />
  </q-page>
</template>
