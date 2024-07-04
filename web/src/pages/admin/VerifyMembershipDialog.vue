<script setup lang="ts">
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

const DEFAULT_FIELDS = {
  validStart: new Date(new Date().getFullYear(), 0, 1) /* Beginning of the year */,
  validUntil: new Date(new Date().getFullYear(), 12, 0) /* End of the year */,
  registrationId: '',
};

const toFields = (value: typeof DEFAULT_FIELDS) => ({
  ...value,
  validStart: (value.validStart || DEFAULT_FIELDS.validStart).toISOString().slice(0, 10),
  validUntil: (value.validUntil || DEFAULT_FIELDS.validUntil).toISOString().slice(0, 10),
});

interface Props {
  mode?: 'edit' | 'accept';
  name: string;
  value?: Partial<typeof DEFAULT_FIELDS>;
}

const props = withDefaults(defineProps<Props>(), {
  mode: 'accept',
  value: () => ({}),
});

defineEmits([
  ...useDialogPluginComponent.emits,
]);

const {
  dialogRef, onDialogHide, onDialogOK, onDialogCancel,
} = useDialogPluginComponent();

const fields = ref(toFields({ ...DEFAULT_FIELDS, ...props.value }));

function onOKClick() {
  onDialogOK(fields.value);
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
    @hide="onDialogHide"
  >
    <q-card class="q-dialog-plugin">
      <q-card-section class="q-dialog__title">
        {{ mode === 'accept' ? 'Terima Ajuan Keanggotaan' : 'Edit Keanggotaan' }}
      </q-card-section>
      <q-card-section class="q-dialog__message">
        Masukkan masa berlaku keanggotaan
        <div><b>{{ name }}</b>.</div>
      </q-card-section>

      <q-card-section>
        <q-input
          v-model="fields.validStart"
          type="date"
          label="Mulai masa berlaku*"
          hint=""
        />
        <q-input
          v-model="fields.validUntil"
          type="date"
          label="Akhir masa berlaku*"
          hint=""
        />
        <q-input
          v-model="fields.registrationId"
          label="ID Registrasi"
          hint="Jika ada, ID lama"
        />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn
          color="primary"
          label="Cancel"
          flat
          @click="onDialogCancel"
        />
        <q-btn
          color="primary"
          label="Simpan"
          @click="onOKClick"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
