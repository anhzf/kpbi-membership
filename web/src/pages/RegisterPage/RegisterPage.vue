<!-- TODO: Add selection for University from database -->
<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="w-full max-w-screen-sm">
      <q-card-section class="q-pb-sm">
        <h1 class="text-h5 my-2">
          Daftar menjadi anggota
        </h1>

        <q-breadcrumbs>
          <template #separator>
            <q-icon name="chevron_right" />
          </template>

          <q-breadcrumbs-el
            label="Isi profil"
            :to="{query: {step: 1}}"
            replace
          />
          <q-breadcrumbs-el
            label="Buat akun"
            :to="{query: {step: 2}}"
            replace
            :disable="!isProgramValid"
          />
          <q-breadcrumbs-el
            label="Verifikasi"
            :to="{query: {step: 3}}"
            replace
          />
        </q-breadcrumbs>
      </q-card-section>

      <q-separator spaced />

      <q-card-section class="q-py-lg">
        <q-form
          id="form_register"
          class="column q-gutter-sm"
          @submit="onSubmit()"
        >
          <template v-if="step === 1">
            <q-select
              v-model="fields.degree"
              label="Jenjang"
              outlined
              :options="degreeOptions"
              :rules="[requiredRule]"
              map-options
              emit-value
            />

            <q-input
              v-model="fields.collegeName"
              label="Nama perguruan tinggi"
              outlined
              :rules="[requiredRule]"
            />

            <q-input
              v-model="fields.collegeShortName"
              label="Nama singkat perguruan tinggi"
              outlined
              :rules="[requiredRule]"
            />

            <q-input
              v-model="fields.programName"
              label="Nama prodi"
              outlined
              :rules="[requiredRule]"
            />
          </template>

          <template v-if="step === 2">
            <q-input
              v-model="fields.email"
              label="Alamat email"
              type="email"
              outlined
              :rules="[requiredRule]"
            />
            <q-input
              v-model="fields.password"
              label="Password"
              :type="showPassword ? 'password' : 'text'"
              outlined
              :rules="[requiredRule]"
            >
              <template #append>
                <q-icon
                  :name="showPassword ? 'visibility' : 'visibility_off'"
                  class="cursor-pointer"
                  @click="showPassword = !showPassword"
                />
              </template>
            </q-input>
            <q-input
              v-model="fields.passwordConfirmation"
              label="Ulangi password"
              :type="showPassword ? 'password' : 'text'"
              outlined
              :rules="[requiredRule, shouldEq('password')]"
            >
              <template #append>
                <q-icon
                  :name="showPassword ? 'visibility' : 'visibility_off'"
                  class="cursor-pointer"
                  @click="showPassword = !showPassword"
                />
              </template>
            </q-input>
          </template>
        </q-form>

        <div class="absolute inset-0 bg-slate/50 column justify-center">
          <p class="text-center">
            Mohon maaf, fitur ini untuk sementara tidak tersedia <span class="text-lg">🙏</span>
          </p>
          <small class="text-center">
            Silakan hubungi admin jika diperlukan.
          </small>
        </div>
      </q-card-section>

      <q-separator spaced />

      <q-card-actions align="between">
        <template v-if="step === 1">
          <q-btn
            label="Masuk"
            flat
            icon="chevron_left"
            color="blue-grey"
            :to="{name: 'Login'}"
          />
          <q-btn
            label="Selanjutnya"
            icon-right="arrow_forward"
            color="primary"
            :disabled="!isProgramValid"
            @click="step = 2"
          />
        </template>

        <template v-if="step === 2">
          <q-btn
            label="Sebelumnya"
            flat
            color="blue-grey"
            icon="arrow_back"
            @click="step = 1"
          />
          <q-btn
            label="Daftar dan buat akun"
            type="submit"
            color="primary"
            form="form_register"
          />
        </template>
      </q-card-actions>

      <q-inner-loading :showing="onSubmitLoading" />
    </q-card>
  </q-page>
</template>

<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import axios from 'axios';
import memberService from 'src/services/member';
import { AcademicDegree, ACADEMIC_DEGREES_LABELS } from 'src/types/constants';
import { requiredRule, shouldEq } from 'src/utils/input-rules';
import {
  computed, reactive, ref, watch,
} from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const step = ref(1);
const showPassword = ref(false);
const fields = reactive({
  degree: '' as AcademicDegree,
  collegeName: '',
  _collegeShortName: '',
  get collegeShortName() {
    return this._collegeShortName;
  },
  set collegeShortName(v) {
    this._collegeShortName = v.toLocaleUpperCase();
  },
  programName: '',
  email: '',
  password: '',
  passwordConfirmation: '',
});
const isProgramValid = computed(() => fields.degree && fields.collegeName && fields.collegeShortName && fields.programName);

const { execute: onSubmit, isLoading: onSubmitLoading } = useAsyncState<void>(async () => {
  try {
    await memberService.register({
      degree: fields.degree,
      college_name: fields.collegeName,
      college_short_name: fields.collegeShortName,
      program_name: fields.programName,
      email: fields.email,
      password: fields.password,
      password_confirmation: fields.passwordConfirmation,
    });
  } catch (err) {
    if (axios.isAxiosError(err)) {
      //
    }
  }
}, undefined, { immediate: false });

watch(step, (v) => {
  router.replace({ query: { step: v } });
});

const degreeOptions = Object.entries(ACADEMIC_DEGREES_LABELS).map(([key, value]) => ({
  label: `${value} - ${key.toUpperCase()}`,
  value: key as AcademicDegree,
}));
</script>
