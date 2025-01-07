<script lang="ts" setup>
import DefineState from 'components/DefineState.vue';
import CardHeader from 'components/MemberProfile/CardHeader.vue';
import CollegeCard from 'components/MemberProfile/CollegeCard.vue';
import HeadOfProgramCard from 'components/MemberProfile/HeadOfProgramCard.vue';
import ProgramCard from 'components/MemberProfile/ProgramCard.vue';
import useMemberProfile, { useIsMemberItself } from 'src/composables/use-member-profile';

const isOwner = useIsMemberItself();
const { state: data, isLoading, refresh } = useMemberProfile();
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
      <DefineState
        :value="data.period_end > new Date()"
        #="{state: [isVerified]}"
      >
        <div :class="['text-center py-.5 mb-1 text-white', isVerified ? 'bg-positive' : 'bg-negative']">
          {{ isVerified
            ? `Aktif sampai ${data.period_end.toLocaleString('id', {dateStyle: 'short'})}`
            : 'Belum Terverifikasi' }}
        </div>
      </DefineState>

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

      <q-card-section class="flex flex-col lg:flex-row q-col-gutter-sm">
        <div class="flex-1 column q-col-gutter-sm">
          <div>
            <ProgramCard
              :data="data.education_program"
              @updated="refresh"
            />
          </div>

          <div>
            <HeadOfProgramCard
              :data="data.responsible"
            />
          </div>
        </div>

        <div class="flex-1 column q-col-gutter-sm">
          <div>
            <CollegeCard
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
