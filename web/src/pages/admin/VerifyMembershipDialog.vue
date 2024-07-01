<script setup lang="ts">
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

const DEFAULT_FIELDS = {
  validStart: new Date(new Date().getFullYear(), 0, 1).toISOString().slice(0, 10) /* Beginning of the year */,
  validUntil: new Date(new Date().getFullYear(), 12, 0).toISOString().slice(0, 10) /* End of the year */,
  registrationId: '',
};

interface Props {
  name: string;
}

defineProps<Props>();

defineEmits([
  ...useDialogPluginComponent.emits,
]);

const {
  dialogRef, onDialogHide, onDialogOK, onDialogCancel,
} = useDialogPluginComponent();

const fields = ref(DEFAULT_FIELDS);

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
        Terima Ajuan Keanggotaan
      </q-card-section>
      <q-card-section class="q-dialog__message">
        Mohon masukkan masa berlaku keanggotaan
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
