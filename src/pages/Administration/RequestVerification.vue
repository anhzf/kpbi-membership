<template>
  <div class="full-width column items-center">
    <q-form
      class="full-width max-w-xs column"
      @submit.prevent="onSubmit"
    >
      <q-card
        flat
        bordered
      >
        <q-card-section class="q-gutter-y-lg">
          <q-uploader
            label="Upload berkas bukti pembayaran"
            :factory="upload"
            accept=".jpeg, .jpg, .png"
            auto-upload
            class="full-width"
          />

          <q-input
            v-model="masaBerlaku"
            label="Masa keanggotaan yang diajukan (tahun)"
            type="number"
            :hint="`Berlaku sampai ${masaBerlakuDate.toLocaleDateString()}`"
            required
          />
        </q-card-section>

        <q-card-actions align="right">
          <div class="row justify-end">
            <q-btn
              label="Kirim permintaan verifikasi"
              type="submit"
              color="primary"
            />
          </div>
        </q-card-actions>
      </q-card>
    </q-form>
  </div>
</template>

<script lang="ts">
import {
  defineComponent, reactive, computed, toRefs,
} from 'vue';
import { date, Notify } from 'quasar';
import fbs from 'src/firebaseService';
import VerificationRequestUseCase from 'src/useCases/verificationRequest';
import { promiseProxy } from 'src/helpers';

export default defineComponent({
  name: 'RequestVerification',
  setup() {
    const state = reactive({
      masaBerlaku: 1,
      uploadedDocument: undefined as (File | undefined),
    });
    const masaBerlakuDate = computed(() => date
      .addToDate(new Date(), { years: state.masaBerlaku }));
    const upload = ([file]: File[]) => {
      state.uploadedDocument = file;
    };
    const onSubmit = promiseProxy(() => {
      if (state.uploadedDocument) {
        return VerificationRequestUseCase.create(
          { masaBerlaku: fbs.firestore.Timestamp.fromDate(masaBerlakuDate.value) },
          state.uploadedDocument,
        )
          .then(() => Notify.create({ type: 'positive', message: 'Berhasil mengirim permintaan verifikasi!' }));
      }

      throw new Error('Mohon pilih dokumen bukti pembayaran');
    });

    return {
      ...toRefs(state), masaBerlakuDate, upload, onSubmit,
    };
  },
});
</script>
