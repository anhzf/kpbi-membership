<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="w-full max-w-screen-sm">
      <q-card-section>
        <h1 class="text-h5">
          Atur ulang kata sandi
        </h1>
      </q-card-section>

      <q-separator spaced />

      <q-card-section class="q-pb-lg">
        <q-form
          id="form_reset-password"
          class="columns q-gutter-md"
          @submit="onSubmit"
        >
          <q-input
            v-model="formData.password"
            label="Masukkan kata sandi yang baru"
            :type="showPassword ? 'text' : 'password'"
            outlined
            :rules="[requiredRule]"
          >
            <template #append>
              <q-icon
                :name="showPassword ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="showPassword = !showPassword"
              />
            </template>
          </q-input>
          <q-input
            v-model="formData.password_confirmation"
            label="Ulangi kata sandi yang baru"
            :type="showPassword ? 'text' : 'password'"
            outlined
            :rules="[requiredRule, shouldEq('password', formData.password)]"
          >
            <template #append>
              <q-icon
                :name="showPassword ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="showPassword = !showPassword"
              />
            </template>
          </q-input>
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
          form="form_reset-password"
        />
      </q-card-actions>

      <q-inner-loading :showing="isLoading" />
    </q-card>
  </q-page>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue';
import { requiredRule, shouldEq } from 'src/utils/input-rules';
import userService from 'src/services/user';
import { useAsyncState } from '@vueuse/core';
import { useRouter } from 'vue-router';
import { Notify } from 'quasar';

const router = useRouter();
const showPassword = ref(false);
const formData = reactive({
  password: '',
  password_confirmation: '',
});

const { execute, isLoading } = useAsyncState<void>(async () => {
  await userService.resetPassword({
    email: String(router.currentRoute.value.query.email),
    password: formData.password,
    password_confirmation: formData.password_confirmation,
    token: String(router.currentRoute.value.query.token),
  });
}, undefined, { immediate: false });

const onSubmit = async () => {
  await execute();
  Notify.create('Silakan login dengan password yang baru :)');
  await router.push({ name: 'Login' });
};
</script>
