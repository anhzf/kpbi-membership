<script lang="ts" setup>
import axios from 'axios';
import { Notify } from 'quasar';
import { useAuthStore } from 'src/stores/auth';
import { requiredRule } from 'src/utils/input-rules';
import { getErrMsg } from 'src/utils/simpler';
import { reactive, ref } from 'vue';

const auth = useAuthStore();
const fields = reactive({
  email: '',
  password: '',
});
const hidePassword = ref(true);

const onSubmit = async () => {
  try {
    await auth.login({
      username: fields.email,
      password: fields.password,
    });
  } catch (err) {
    Notify.create({ type: 'negative', message: getErrMsg(err) });
    if (!(axios.isAxiosError(err) && err.response?.status
          && (err.response.status >= 400 || err.response.status < 500))) {
      console.error(err);
    }
  }
};
</script>

<template>
  <q-page
    padding
    class="column justify-center items-center"
  >
    <q-card class="mb-10vh w-full max-w-xs">
      <q-card-section>
        <q-img
          src="/images/Optimized-ICON_KPBI.png"
          fit="scale-down"
          class="max-h-150px"
        />
        <h6 class="text-h6 text-center mt-4 mb-2">
          Login
        </h6>
      </q-card-section>

      <q-card-section class="q-pt-none q-pb-xl">
        <q-form
          id="form_login"
          class="column"
          @submit.prevent="onSubmit"
        >
          <q-input
            v-model="fields.email"
            label="Email"
            type="email"
            :rules="[requiredRule]"
            autofocus
          />
          <q-input
            v-model="fields.password"
            label="Password"
            :type="hidePassword ? 'password' : 'text'"
            :rules="[requiredRule]"
          >
            <template #append>
              <q-icon
                :name="hidePassword ? 'visibility' : 'visibility_off'"
                class="cursor-pointer"
                @click="hidePassword = !hidePassword"
              />
            </template>
          </q-input>

          <router-link
            :to="{ name: 'ForgotPassword' }"
            class="text-primary"
          >
            <small>Lupa kata sandi? Klik disini</small>
          </router-link>
        </q-form>
      </q-card-section>

      <q-card-actions align="between">
        <q-btn
          label="Daftar"
          color="blue-grey"
          flat
          :to="{ name: 'Register' }"
        />

        <q-btn
          label="Masuk"
          type="submit"
          color="primary"
          form="form_login"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>
