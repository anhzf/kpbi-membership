<script lang="ts" setup>
import useMemberProfile from 'src/composables/use-member-profile';
import memberService from 'src/services/member';
import { pdfGetUrl } from 'src/services/pdf';
import { ACADEMIC_DEGREES_LABELS, AcademicDegree } from 'src/types/constants';
import { pageLoading, toastErrorIfAny } from 'src/utils/ui';
import { computed, ref, toRaw } from 'vue';
import { Notify } from 'quasar';
import AsyncState from '../AsyncState.vue';

interface Props {
  editMode?: boolean;
  degree: AcademicDegree;
  programName: string;
  collegeName: string;
  collegeShortName: string;
  collegeImg?: string;
  department?: string;
  faculty?: string;
}

const props = defineProps<Props>();
const modified = ref<Props>(toRaw(props));

const { state: data } = useMemberProfile();

const isViewCertificateClicked = ref(false);
const certificateUrl = computed(() => (isViewCertificateClicked.value
  ? pdfGetUrl(`keanggotaan/${data.value?.id}`, {
    format: 'A4', landscape: true, margin: 0, printBackground: true,
  }).then((v) => {
    Notify.create('Sertifikat siap diunduh. Silakan klik kembali jika tidak terbuka otomatis.');
    window.open(v, '_blank');
    return v;
  })
  : Promise.resolve(undefined)));

const onPhotoChange = async (ev: Event) => {
  const target = ev.target as HTMLInputElement;
  if (target.files?.length) {
    const file = target.files[0];

    await toastErrorIfAny(
      pageLoading(memberService.updateCollege({ img: file })),
    );

    modified.value.collegeImg = URL.createObjectURL(file);
  }
};

const onViewCertificateClick = () => {
  isViewCertificateClicked.value = true;
  Notify.create({
    message: 'Menyiapkan sertifikat...',
  });
};
</script>

<template>
  <div class="row items-center gap-x-6">
    <q-avatar
      size="10rem"
      color="grey-5"
      class="group"
    >
      <div class="absolute-center text-center text-h6 -rotate-45 -translate-1/2 opacity-50">
        Logo Perguruan Tinggi
      </div>

      <q-img :src="modified.collegeImg" />

      <q-btn
        v-if="editMode"
        icon="upload"
        flat
        round
        class="opacity-0 group-hover:!opacity-100 absolute-full transition-opacity"
      >
        <label>
          <input
            type="file"
            accept="image/jpg, image/jpeg, image/png"
            class="absolute-full cursor-pointer opacity-0"
            @change="onPhotoChange"
          >
        </label>
      </q-btn>
    </q-avatar>

    <div class="column">
      <h1 class="column m-0">
        <span class="text-h3 flex items-center">
          <span>
            {{ ACADEMIC_DEGREES_LABELS[degree] }} {{ programName }}
          </span>
        </span>
        <span class="text-h5 text-blue-grey-10">
          {{ collegeName }} ({{ collegeShortName }})
        </span>
        <p class="text-subtitle1 text-blue-grey">
          {{ department }}{{ faculty }}
        </p>
      </h1>

      <div class="row q-gutter-md">
        <q-btn
          label="Lihat Matkul MBKM"
          :to="{name: 'Courses'}"
          outline
        />
        <AsyncState
          v-if="data?.period_end && data?.period_end > new Date()"
          :value="certificateUrl"
          :init="undefined"
          #="{state,isLoading,error}"
        >
          <q-btn
            label="Lihat Sertifikat"
            :href="state"
            target="_blank"
            outline
            :loading="isLoading"
            :title="error ? 'Document not available currently' : 'Lihat sertifikat keanggotaan'"
            :disable="!!error"
            @click.once="onViewCertificateClick"
          />
        </AsyncState>
      </div>
    </div>
  </div>
</template>
