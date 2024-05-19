<script lang="ts" setup>
import { Accreditation } from 'src/types/models';
import type { Values } from './AccreditationForm.vue';

interface Props {
  editMode?: boolean;
 data: Partial<Accreditation>[];
}

interface Emits {
  (ev: 'request-form', values?: Partial<Values>): void;
  (ev: 'request-delete', id: string): void;
}

defineProps<Props>();
defineEmits<Emits>();
</script>

<template>
  <q-item
    v-for="accreditation in data"
    :key="accreditation.id"
  >
    <q-item-section>
      <q-item-label class="font-medium text-blue-grey-10">
        {{ accreditation.value }}
      </q-item-label>
      <q-item-label
        caption
        class="flex gap-2"
      >
        <div class="font-medium">
          {{ accreditation.label }}
        </div>
        <q-separator vertical />
        <div>
          Exp:
          {{ accreditation.valid_from?.toLocaleDateString() }} —
          {{ accreditation.valid_until?.toLocaleDateString() }}
        </div>
      </q-item-label>
    </q-item-section>

    <q-item-section
      v-if="editMode"
      side
    >
      <div class="flex">
        <q-btn
          icon="edit"
          flat
          round
          @click="$emit('request-form', accreditation)"
        />
        <q-btn
          icon="delete"
          flat
          round
          color="red-5"
          @click="$q.dialog({
            title: 'Hapus data akreditasi',
            message: 'Apakah Anda yakin ingin menghapus data akreditasi ini?',
            persistent: true,
            ok: 'Ya',
            cancel: 'Tidak',
          }).onOk(() => $emit('request-delete', accreditation.id!))"
        />
      </div>
    </q-item-section>
  </q-item>

  <q-item v-if="editMode">
    <q-btn
      label="Tambah data akreditasi"
      icon="add"
      flat
      @click="$emit('request-form')"
    />
  </q-item>
</template>
