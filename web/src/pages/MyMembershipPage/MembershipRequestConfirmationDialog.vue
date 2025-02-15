<script setup lang="ts">
import { useDialogPluginComponent } from 'quasar';
import { dateTimeRule, requiredRule } from 'src/utils/input-rules';
import { toIndonesianWords } from 'src/utils/number';
import { ref } from 'vue';
import { capitalCase } from 'change-case';

const DEFAULT_FIELDS = {
  transferAt: new Date(),
  amount: 0,
};

const toFields = (value: typeof DEFAULT_FIELDS) => ({
  ...value,
  transferAt: (value.transferAt || DEFAULT_FIELDS.transferAt).toISOString().slice(0, 10),
});

interface Props {
  file: File;
}

defineProps<Props>();

defineEmits([
  ...useDialogPluginComponent.emits,
]);

const {
  dialogRef, onDialogHide, onDialogOK, onDialogCancel,
} = useDialogPluginComponent();

const fields = ref(toFields(DEFAULT_FIELDS));

function onOKClick() {
  onDialogOK({
    transferAt: new Date(fields.value.transferAt),
    amount: Number(fields.value.amount),
  });
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
    @hide="onDialogHide"
  >
    <q-card class="q-dialog-plugin">
      <q-card-section class="q-dialog__title">
        Konfirmasi Unggah Bukti Pembayaran
      </q-card-section>
      <q-card-section class="q-dialog__message">
        Anda akan mengunggah <b class="underline underline-dashed">{{ file.name }}</b> sebagai bukti pembayaran.
      </q-card-section>

      <q-card-section>
        <q-input
          v-model="fields.transferAt"
          type="datetime-local"
          label="Tanggal Transfer*"
          hint=""
          :rules="[requiredRule, dateTimeRule]"
        />
        <q-input
          v-model.number="fields.amount"
          type="number"
          label="Jumlah Transfer*"
          prefix="Rp "
          :hint="capitalCase(`${toIndonesianWords(fields.amount)} rupiah`)"
          :rules="[requiredRule]"
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
