<script lang="ts" setup>
import { AcademicDegree, ACADEMIC_DEGREES_LABELS } from 'src/types/constants';

interface Props {
  degree: AcademicDegree;
  programName: string;
  collegeName: string;
  collegeShortName: string;
  collegeImg?: string;
  department?: string;
  faculty?: string;
}

defineProps<Props>();
</script>

<template>
  <div class="row items-center gap-x-6">
    <q-avatar
      size="10rem"
      color="grey-5"
    >
      <q-img :src="collegeImg" />
    </q-avatar>

    <div class="column">
      <h1 class="column m-0">
        <span class="text-h3">
          {{ ACADEMIC_DEGREES_LABELS[degree] }} {{ programName }}
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
      </div>
    </div>
  </div>
</template>
