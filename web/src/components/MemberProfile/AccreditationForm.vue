<script lang="ts" setup>
import { requiredRule } from 'src/utils/input-rules';
import { ref } from 'vue';

const ACCREDITATION_VALUES = ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'] as const;

// const dateToInputString = (date: Date) => [
//   date.getFullYear(),
//   date.getMonth() + 1,
//   date.getDate(),
// ].map((n) => n.toString().padStart(2, '0')).join('-');

export interface Values {
  id: string;
  label: string;
  value: typeof ACCREDITATION_VALUES[number];
  valid_from: Date;
  valid_until: Date;
}

interface Props {
  title?: string;
  objectName?: string;
  data?: Partial<Values>;
}

interface Emits {
  (ev: 'submit', values: Values): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const fields = ref({
  label: props.data?.label || '',
  value: props.data?.value || '',
  valid_from: props.data?.valid_from?.toISOString().slice(0, 10).replaceAll('-', '/') || '',
  valid_until: props.data?.valid_until?.toISOString().slice(0, 10).replaceAll('-', '/') || '',
});

const onSubmit = () => {
  emit('submit', {
    id: props.data?.id || '',
    label: fields.value.label,
    value: fields.value.value as typeof ACCREDITATION_VALUES[number],
    valid_from: new Date(fields.value.valid_from),
    valid_until: new Date(fields.value.valid_until),
  });
};
</script>

<template>
  <q-card>
    <q-form @submit.prevent="onSubmit">
      <q-card-section>
        <div class="text-h6">
          {{ title || 'Data akreditasi' }}
        </div>
        <div
          v-if="objectName"
          class="text-caption text-blue-grey"
        >
          Akreditasi untuk: {{ objectName }}
        </div>
      </q-card-section>

      <q-card-section class="flex flex-col gap-2">
        <q-input
          v-model="fields.label"
          label="Label"
          :rules="[requiredRule]"
        />

        <q-select
          v-model="fields.value"
          label="Penilaian"
          :rules="[requiredRule]"
          :options="ACCREDITATION_VALUES"
        />

        <q-input
          v-model="fields.valid_from"
          label="Tanggal Mulai"
          mask="date"
          :rules="['date']"
        >
          <template #append>
            <q-icon
              name="event"
              class="cursor-pointer"
            >
              <q-popup-proxy
                cover
                transition-show="scale"
                transition-hide="scale"
              >
                <q-date v-model="fields.valid_from">
                  <div class="row items-center justify-end">
                    <q-btn
                      v-close-popup
                      label="Close"
                      color="primary"
                      flat
                    />
                  </div>
                </q-date>
              </q-popup-proxy>
            </q-icon>
          </template>
        </q-input>

        <q-input
          v-model="fields.valid_until"
          label="Tanggal Selesai"
          mask="date"
          :rules="['date']"
        >
          <template #append>
            <q-icon
              name="event"
              class="cursor-pointer"
            >
              <q-popup-proxy
                cover
                transition-show="scale"
                transition-hide="scale"
              >
                <q-date v-model="fields.valid_until">
                  <div class="row items-center justify-end">
                    <q-btn
                      v-close-popup
                      label="Close"
                      color="primary"
                      flat
                    />
                  </div>
                </q-date>
              </q-popup-proxy>
            </q-icon>
          </template>
        </q-input>
      </q-card-section>

      <q-card-actions>
        <q-space />
        <q-btn
          label="Simpan"
          type="submit"
          color="primary"
        />
      </q-card-actions>
    </q-form>
  </q-card>
</template>
