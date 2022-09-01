<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="w-full max-w-screen-sm">
      <q-card-section>
        <h1 class="text-h5">
          Lupa kata sandi
        </h1>
      </q-card-section>

      <q-separator spaced />

      <q-card-section class="q-pb-lg">
        <q-form
          id="form_forgot-password"
          class="columns q-gutter-md"
          @submit="onSubmit"
        >
          <q-input
            v-model="formData.email"
            label="Masukkan alamat email anda disini"
            type="email"
            outlined
            :rules="[requiredRule]"
            hint="Kami akan mengirim email ke alamat tersebut untuk me-reset password"
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
          :to="{ name: 'Login' }"
        />
        <q-btn
          label="Kirim"
          type="submit"
          color="primary"
          form="form_forgot-password"
        />
      </q-card-actions>

      <q-inner-loading :showing="isLoading" />
    </q-card>
  </q-page>
</template>

<script lang="ts" setup>
import { reactive } from 'vue';
import { requiredRule } from 'src/utils/input-rules';
import userService from 'src/services/user';
import { useAsyncState } from '@vueuse/core';

const formData = reactive({
  email: '',
});

const { execute, isLoading } = useAsyncState<void>(async () => {
  await userService.sendResetPasswordRequest({ email: formData.email });
}, undefined, { immediate: false });

const onSubmit = async () => {
  await execute();
};
</script>
