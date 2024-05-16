<script lang="ts" setup>
import memberService from 'src/services/member';
import { COLLEGE_TYPES_LABELS } from 'src/types/constants';
import { College } from 'src/types/models';
import { inferDiffs } from 'src/utils/object';
import { pageLoading, toastErrorIfAny } from 'src/utils/ui';
import { ref } from 'vue';
import CollegeFields from './CollegeFields.vue';

interface Props {
  data: College;
}

interface Emits {
  (ev: 'updated'): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const elmFields = ref<typeof CollegeFields>();
const showForm = ref(false);

const onUpdateFormSubmit = async () => {
  const fields = inferDiffs(elmFields.value?.fields, props.data);

  await toastErrorIfAny(
    pageLoading(memberService.updateCollege(fields)),
  );

  emit('updated');
  showForm.value = false;
};
</script>

<template>
  <q-card
    flat
    bordered
  >
    <q-card-section>
      <div class="flex justify-between items-center gap-2">
        <h3 class="text-h6 m-0">
          Kampus
        </h3>
        <q-btn
          icon="edit"
          color="grey"
          flat
          round
          @click="showForm = true"
        />
      </div>

      <q-list>
        <q-item-label header>
          Akreditasi
        </q-item-label>
        <q-item
          v-for="accreditation in data.accreditations"
          :key="accreditation.id"
        >
          <q-item-section>
            <q-item-label overline>
              {{ accreditation.label }}
            </q-item-label>
            <q-item-label>
              <span class="text-h6 m-0">
                {{ accreditation.value }}
              </span>
            </q-item-label>
          </q-item-section>
          <q-item-section
            side
            top
          >
            <q-item-label caption>
              {{ accreditation.valid_from?.toLocaleDateString() }}—
            </q-item-label>
            <q-item-label caption>
              {{ accreditation.valid_until?.toLocaleDateString() }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-separator />

        <q-item-label header>
          Umum
        </q-item-label>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Alamat
            </q-item-label>
            <q-item-label>
              {{ [data.street_address, data.city, data.province].filter(Boolean).join(', ') || '-' }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Status
            </q-item-label>
            <q-item-label>{{ COLLEGE_TYPES_LABELS[data.type] || '-' }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>

    <q-dialog
      v-model="showForm"
      persistent
    >
      <q-card class="w-prose max-w-90vw">
        <q-form @submit.prevent="onUpdateFormSubmit">
          <q-card-section>
            <div class="text-h6">
              Perbarui Kampus
            </div>
          </q-card-section>

          <q-card-section class="flex flex-col gap-2">
            <college-fields
              ref="elmFields"
              :data="data"
            />
          </q-card-section>

          <q-card-actions>
            <q-btn
              label="Batal"
              flat
              @click="showForm = false"
            />
            <q-space />
            <q-btn
              label="Simpan"
              color="primary"
              type="submit"
            />
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>
  </q-card>
</template>
