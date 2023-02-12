<script lang="ts" setup>
import { QForm } from 'quasar';
import { COURSE_SEMESTER_TYPES_LABELS } from 'src/types/constants';
import { Course } from 'src/types/models';
import { requiredRule } from 'src/utils/input-rules';
import { ref } from 'vue';

interface Props {
  modelValue: Partial<Course>;
  isLoading?: boolean;
}

interface Emits {
  (e: 'update:modelValue', data: Partial<Course>): void;
}

const props = withDefaults(defineProps<Props>(), {
  isLoading: false,
});
const emit = defineEmits<Emits>();

const courseForm = ref<QForm>();
const field = ref<Partial<Course>>(props.modelValue);

const onFormReset = () => {
  field.value.id = undefined;
  field.value.name = '';
  field.value.code = '';
  field.value.credits = undefined;
  field.value.semester = undefined;
  field.value.info!.cpmk = '';
  field.value.lecturer = '';
  field.value.description = '';
};

const onFormSubmit = () => {
  emit('update:modelValue', field.value);
};
</script>

<template>
  <q-card class="w-full max-w-screen-sm">
    <q-form
      ref="courseForm"
      :method="field.id ? 'PUT' : 'POST'"
      @reset="onFormReset"
      @submit="onFormSubmit"
    >
      <q-card-section>
        <div
          v-if="field.id"
          class="text-h6"
        >
          Perbarui Mata Kuliah MBKM
        </div>
        <div
          v-else
          class="text-h6"
        >
          Tambah Mata Kuliah MBKM
        </div>
      </q-card-section>

      <q-card-section>
        <q-select
          v-model="field.semester"
          label="Semester"
          filled
          :options="Object.entries(COURSE_SEMESTER_TYPES_LABELS).map(([key, value]) => ({ label: value, value: key }))"
          emit-value
          map-options
          autofocus
          :rules="[requiredRule]"
        />
      </q-card-section>

      <q-separator />

      <q-slide-transition>
        <q-card-section v-show="field.semester">
          <q-input
            v-model="field.name"
            label="Nama Mata Kuliah"
            outlined
            :disable="!field.semester"
            :rules="[requiredRule]"
          />

          <q-input
            v-model="field.code"
            label="Kode Mata Kuliah"
            outlined
            :disable="!field.semester"
            :rules="[requiredRule]"
          />

          <q-input
            v-model="field.credits"
            label="Beban SKS"
            type="number"
            outlined
            :disable="!field.semester"
            :rules="[requiredRule]"
          />

          <q-input
            v-model="field.description"
            label="Deskripsi Mata Kuliah"
            type="textarea"
            outlined
            :disable="!field.semester"
            :rules="[requiredRule]"
          />

          <q-input
            v-model="field.info!.cpmk"
            type="textarea"
            label="CPMK"
            outlined
            :disable="!field.semester"
            :rules="[requiredRule]"
          />

          <q-input
            v-model="field.lecturer"
            label="Dosen Pengampu"
            outlined
            :disable="!field.semester"
            :rules="[requiredRule]"
          />
        </q-card-section>
      </q-slide-transition>

      <slot>
        <q-separator />

        <q-card-actions>
          <q-btn
            label="Kosongkan"
            type="reset"
            flat
          />

          <q-space />

          <q-btn
            label="Simpan"
            type="submit"
            color="primary"
          />
        </q-card-actions>
      </slot>

      <q-inner-loading :showing="isLoading" />
    </q-form>
  </q-card>
</template>
