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
        <q-form
          :id="`${$.uid}__formLogin`"
          class="column"
          @submit.prevent="login"
        >
          <q-input
            v-model="email"
            label="email"
            type="email"
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

          <router-link
            to="#"
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
          :to="{name: 'Register'}"
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

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import { Loading } from 'quasar';
import { auth } from 'src/firebaseService';

export default defineComponent({
  name: 'PageLogin',
  setup() {
    const state = reactive({
      email: '',
      password: '',
      hidePassword: true,
    });
    const login = () => {
      Loading.show();
      return auth.signInWithEmailAndPassword(state.email, state.password)
        .finally(() => Loading.hide());
    };

    return {
      ...toRefs(state),
      login,
    };
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
