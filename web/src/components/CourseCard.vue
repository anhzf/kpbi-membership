<script lang="ts" setup>
import { CourseSemesterType, COURSE_SEMESTER_TYPES_LABELS } from 'src/types/constants';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

interface Props {
  title: string;
  code?: string;
  credits?: number;
  semester?: CourseSemesterType;
  cpmk?: string;
  lecturer?: string;
  description?: string;
  capacity?: number;
}

interface Emits {
  (e: 'update-click'): void;
  (e: 'delete-click'): void;
}

defineProps<Props>();
const emit = defineEmits<Emits>();

const route = useRoute();
const isOwner = computed(() => route.params.memberId === 'me');

const onUpdateClick = () => {
  emit('update-click');
};

const onDeleteClick = () => {
  emit('delete-click');
};
</script>

<template>
  <q-card class="h-full column">
    <q-card-section class="q-pb-xs">
      <div class="text-h6">
        {{ title }}
      </div>
      <div>
        <span class="text-caption">Kode MK: </span>
        <span class="text-subtitle2">
          {{ code }}
        </span>
      </div>
    </q-card-section>

    <q-card-section>
      <q-list>
        <q-item>
          <q-item-section>
            <q-item-label>Jumlah SKS</q-item-label>
            <q-item-label caption>
              {{ credits }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Semester</q-item-label>
            <q-item-label caption>
              {{ semester && COURSE_SEMESTER_TYPES_LABELS[semester] }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>CPMK</q-item-label>
            <q-item-label caption>
              {{ cpmk }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Dosen Pengampu</q-item-label>
            <q-item-label caption>
              {{ lecturer }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Deskripsi</q-item-label>
            <q-item-label caption>
              {{ description }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Kapasitas</q-item-label>
            <q-item-label caption>
              {{ capacity || '-' }} Mahasiswa
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>

    <q-space />

    <template v-if="isOwner">
      <q-separator />

      <q-card-actions class="no-wrap">
        <q-btn
          label="Hapus"
          icon="delete"
          color="negative"
          outline
          class="w-full"
          @click="onDeleteClick"
        />
        <q-btn
          label="Perbarui"
          icon="edit"
          color="secondary"
          outline
          class="w-full"
          @click="onUpdateClick"
        />
      </q-card-actions>
    </template>
  </q-card>
</template>
