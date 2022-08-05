<template>
  <q-page
    padding
    class="column justify-center items-center"
  >
    <q-card class="login-card">
      <q-card-section>
        <q-img
          src="/images/Optimized-ICON_KPBI.png"
          fit="scale-down"
          class="login-card__img"
        />
        <h6 class="text-h6 text-center">
          Login
        </h6>
      </q-card-section>

      <q-card-section class="q-pt-none q-pb-xl">
        <q-form
          :id="`${$.uid}__formLogin`"
          class="column"
          @submit.prevent="onSubmit"
        >
          <q-input
            v-model="fields.email"
            label="Email"
            type="email"
            :rules="[requiredRule]"
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
            <small>Lupa password? Klik disini</small>
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
          :form="`${$.uid}__formLogin`"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue';
import { requiredRule } from 'src/utils/inputRules';
import { useAuthStore } from 'src/stores/auth';

const auth = useAuthStore();
const fields = reactive({
  email: '',
  password: '',
});
const hidePassword = ref(true);

const onSubmit = async () => {
  await auth.login({ ...fields });
};
</script>

<style lang="scss" scoped>
.login-card {
  margin-bottom: 10vh;
  width: 100%;
  max-width: 320px;

  &__img {
    max-height: 150px;
  }
}
</style>
