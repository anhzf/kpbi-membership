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

      <q-card-section class="q-pb-xl">
        <q-form class="column">
          <q-input
            v-model="username"
            label="username"
          />
          <q-input
            v-model="password"
            label="password"
            :type="hidePassword ? 'password' : 'text'"
          >
            <template #append>
              <q-icon
                :name="hidePassword ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="hidePassword = !hidePassword"
              />
            </template>
          </q-input>

          <router-link to="#">
            <small>Lupa password? Klik disini</small>
          </router-link>
        </q-form>
      </q-card-section>

      <q-card-actions align="between">
        <q-btn
          label="Daftar"
          flat
          color="blue-grey"
          :to="{name: 'Register'}"
        />
        <q-btn
          label="Masuk"
          color="primary"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';

export default defineComponent({
  name: 'PageLogin',
  setup() {
    const state = reactive({
      username: '',
      password: '',
      hidePassword: true,
    });

    return toRefs(state);
  },
});
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
