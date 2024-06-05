<script setup lang="ts">
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

const DEFAULT_EXPIRY_MS = 3600_000 * 24 * 365;

defineEmits([
  ...useDialogPluginComponent.emits,
]);

const {
  dialogRef, onDialogHide, onDialogOK, onDialogCancel,
} = useDialogPluginComponent();

const fields = ref({
  validUntil: new Date(Date.now() + DEFAULT_EXPIRY_MS).toISOString().slice(0, 10),
  registrationId: '',
});

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
      </q-card-section>

      <q-card-section>
        <q-input
          v-model="fields.validUntil"
          type="date"
          label="Masa berlaku*"
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
