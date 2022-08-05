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

      <q-card-section class="q-pb-lg">
        <q-form
          :id="`${$.uid}_formRegister`"
          class="columns q-gutter-sm"
          @submit="onSubmit"
        >
          <div class="row gap-x-sm">
            <q-select
              v-model="formData.jenjang"
              label="Jenjang"
              outlined
              :options="[...JENJANG_PRODI]"
              :rules="[requiredRule]"
              class="col-3"
            />

            <q-input
              v-model="formData.namaProdi"
              label="Nama Prodi"
              outlined
              :rules="[requiredRule]"
              class="col-grow"
            />
          </div>

          <div class="row gap-x-sm">
            <small class="col-12 q-pl-sm text-weight-medium text-grey">NAMA PERGURUAN TINGGI</small>
            <q-input
              v-model="formData.perguruanTinggi.singkatan"
              label="Singkat"
              outlined
              :rules="[requiredRule]"
              class="col-shrink"
            />
            <q-input
              v-model="formData.perguruanTinggi.lengkap"
              label="Lengkap"
              outlined
              :rules="[requiredRule]"
              class="col-grow"
            />
          </div>

          <q-input
            v-model="formData.emailProdi"
            label="Email prodi"
            type="email"
            outlined
            :rules="[requiredRule]"
          />

          <q-input
            v-model="formData.kaprodi.email"
            label="Email kaprodi"
            type="email"
            outlined
            :rules="[requiredRule]"
            hint="Harap diingat bahwa email kaprodi ini nanti yang akan digunakan untuk login"
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
          type="submit"
          color="primary"
          :form="`${$.uid}_formRegister`"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script lang="ts" setup>
import { reactive, defineExpose } from 'vue';
import { requiredRule } from 'src/utils/inputRules';
import { JENJANG_PRODI } from 'src/constants';

const formData = reactive({
  jenjang: 'S1',
  namaProdi: '',
  perguruanTinggi: {
    lengkap: '',
    singkatan: '',
  },
  emailProdi: '',
  kaprodi: {
    email: '',
  },
});

const onSubmit = () => {
  //
};

defineExpose({
  formData,
});
</script>

<style lang="scss" scoped>
.register-card {
  width: 100%;
  max-width: $breakpoint-xs;
}
</style>
