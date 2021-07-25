<template>
  <div class="full-width column items-center">
    <q-form class="full-width max-w-xs column">
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
            label="Untuk tahun berlaku sebanyak ... tahun"
            type="number"
            :hint="`Berlaku sampai ${masaBerlakuDate}`"
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
import { date } from 'quasar';
import {
  defineComponent, reactive, computed, toRefs,
} from 'vue';

export default defineComponent({
  name: 'RequestVerification',
  setup() {
    const state = reactive({
      masaBerlaku: 1,
    });
    const masaBerlakuDate = computed(() => date
      .addToDate(new Date(), { years: state.masaBerlaku })
      .toLocaleDateString());
    const upload = (files: File[]) => new Promise((resolve) => {
      setTimeout(() => {
        console.log(files);

        resolve(files);
      }, 3000);
    });

    return { ...toRefs(state), masaBerlakuDate, upload };
  },
});
</script>
