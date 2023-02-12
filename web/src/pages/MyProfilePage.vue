<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import CardHeader from 'components/MemberProfile/CardHeader.vue';
import CollegeCard from 'components/MemberProfile/CollegeCard.vue';
import HeadOfProgramCard from 'components/MemberProfile/HeadOfProgramCard.vue';
import ProgramCard from 'components/MemberProfile/ProgramCard.vue';
import memberService from 'src/services/member';

const { state: data, isLoading } = useAsyncState(() => memberService.get('my'), undefined);
</script>

<template>
  <q-page
    padding
    class="column"
  >
    <q-card
      v-if="data"
      flat
      class="self-center items-start w-full max-w-screen-lg"
    >
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

    <q-page-sticky
      position="bottom-right"
      :offset="[18, 18]"
    >
      <q-btn
        label="Perbarui"
        icon="edit"
        fab
        color="primary"
      />
    </q-page-sticky>

    <q-inner-loading :showing="isLoading" />
  </q-page>
</template>
