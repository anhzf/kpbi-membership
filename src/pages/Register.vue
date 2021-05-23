<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="register-card">
      <q-card-section>
        <h1 class="text-h5">
          Daftar menjadi anggota
        </h1>
      </q-card-section>

      <q-separator spaced />

      <q-card-section class="q-pb-xl">
        <q-form class="columns q-gutter-md">
          <q-select
            v-model="form.jenjang"
            label="Jenjang"
            outlined
            :options="['S1', 'S2', 'S3']"
          />

          <q-input
            v-model="form.namaProdi"
            label="Nama Prodi"
            outlined
          />

          <div class="row">
            <small class="col-12 q-pl-sm text-weight-medium text-grey">NAMA PERGURUAN TINGGI</small>
            <q-input
              v-model="form.namaPerguruanTinggiSingkat"
              label="Singkat"
              outlined
              class="col-shrink"
            />
            <q-input
              v-model="form.namaPerguruanTinggiLengkap"
              label="Lengkap"
              outlined
              class="col-grow"
            />
          </div>

          <q-input
            v-model="form.emailProdi"
            label="Email prodi"
            type="email"
            outlined
          />

          <q-input
            v-model="form.emailKaprodi"
            label="Email kaprodi"
            type="email"
            outlined
          />
        </q-form>
      </q-card-section>

      <q-separator spaced />

      <q-card-actions align="between">
        <q-btn
          label="Masuk"
          flat
          color="blue-grey"
          icon="chevron_left"
          :to="{name: 'Login'}"
        />
        <q-btn
          label="Daftar"
          color="primary"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';

export default defineComponent({
  name: 'PageRegister',
  setup() {
    const formState = reactive({
      jenjang: 'S1',
      namaProdi: '',
      namaPerguruanTinggiLengkap: '',
      namaPerguruanTinggiSingkat: '',
      emailProdi: '',
      emailKaprodi: '',
    });

    return {
      form: formState,
    };
  },
});
</script>

<style lang="scss" scoped>
.register-card {
  width: 100%;
  max-width: $breakpoint-xs;
}
</style>
