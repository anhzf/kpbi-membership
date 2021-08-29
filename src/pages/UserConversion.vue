<template>
  <q-page
    padding
    class="column justify-center items-center"
  >
    <q-card class="login-card">
      <q-card-section>
        <h6 class="text-h6 text-center">
          Konversi akun
        </h6>
      </q-card-section>

      <q-card-section class="q-pt-none q-pb-xl">
        <q-form
          :id="`${$.uid}__formLogin`"
          class="column"
          @submit.prevent="login"
        >
          <q-input
            v-model="username"
            label="username"
            :rules="[requiredRule]"
          />
          <q-input
            v-model="password"
            label="password"
            :type="hidePassword ? 'password' : 'text'"
            :rules="[requiredRule]"
          >
            <template #append>
              <q-icon
                :name="hidePassword ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="hidePassword = !hidePassword"
              />
            </template>
          </q-input>
        </q-form>
      </q-card-section>

      <q-card-actions align="between">
        <q-btn
          label="Masuk"
          color="blue-grey"
          icon="chevron_left"
          outline
          :to="{name: 'Login'}"
        />
        <q-btn
          label="Konversi"
          type="submit"
          color="primary"
          :form="`${$.uid}__formLogin`"
        />
      </q-card-actions>
    </q-card>

    <ul class="max-w-xs">
      <li class="text-red-5 text-italic">
        halaman ini ditujukan bagi yang sudah pernah mendaftar akun pada aplikasi yang lama
      </li>
      <li class="text-red-5 text-italic">
        Dengan masuk melalui halaman ini maka akun lama anda akan dikonversikan menjadi akun yang baru,
        sehingga apabila telah melakukan konversi silahkan login menggunakan email dan password untuk kedepannya
      </li>
    </ul>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import { useRouter } from 'vue-router';
import { Loading, Notify } from 'quasar';
import { useStore } from 'src/store';
import { auth, fns } from 'src/firebaseService';
import { requiredRule } from 'src/inputRules';
import { getErrMsg } from 'src/helpers';
import type fb from 'firebase';

const legacyLoginAndMigrate = fns.httpsCallable('convertLegacyAccountThenLogin');

export default defineComponent({
  name: 'PageUserConversion',
  setup() {
    const state = reactive({
      username: '',
      password: '',
      hidePassword: true,
    });
    const store = useStore();
    const router = useRouter();
    const login = () => {
      Loading.show();
      store.commit('auth/setIsWaiting', true);
      store.commit('auth/setAfterLoginFn', () => router
        .push({ name: 'AccountSettings' }));

      legacyLoginAndMigrate({ name: state.username, password: state.password })
        .then(({ data }) => {
          Notify.create({ type: 'positive', message: 'Berhasil mengkonversi akun!' });
          return auth.signInWithCustomToken(data);
        })
        .catch((err: fb.auth.Error) => {
          Notify.create({ message: getErrMsg(err), type: 'negative' });
          return store.dispatch('auth/afterUnauthenticated');
        })
        .finally(() => Loading.hide());
    };

    return {
      ...toRefs(state),
      login,
      // utils
      requiredRule,
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
