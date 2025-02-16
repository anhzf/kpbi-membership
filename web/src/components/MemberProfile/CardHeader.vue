<script lang="ts" setup>
import useMemberProfile from 'src/composables/use-member-profile';
import memberService from 'src/services/member';
import { ACADEMIC_DEGREES_LABELS, AcademicDegree } from 'src/types/constants';
import { pageLoading, toastErrorIfAny } from 'src/utils/ui';
import { ref, toRaw } from 'vue';

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
        <q-btn
          label="Lihat Sertifikat"
          :to="{name: 'DocumentMembership', params: {memberId: data?.id}}"
          target="_blank"
          outline
          title="Lihat sertifikat keanggotaan"
        />
      </div>
    </div>
  </div>
</template>
