<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="forgot-card">
      <q-card-section>
        <h1 class="text-h5">
          Lupa password
        </h1>
      </q-card-section>

      <q-separator spaced />

      <q-card-section class="q-pb-lg">
        <q-form
          :id="`${$.uid}_formForgotPassword`"
          class="columns q-gutter-md"
          @submit="onSubmit"
        >
          <q-input
            v-model="form.email"
            label="Email"
            type="email"
            outlined
            :rules="[requiredRule]"
            hint="Kirim email untuk me-reset password"
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
          label="Kirim"
          type="submit"
          color="primary"
          :form="`${$.uid}_formForgotPassword`"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import { Loading, Notify } from 'quasar';
import { auth } from 'src/firebaseService';
import { requiredRule } from 'src/inputRules';
import { getErrMsg } from 'src/helpers';

export default defineComponent({
  setup() {
    const formData = reactive({
      email: '',
    });

    return {
      form: formData,
      // utils
      requiredRule,
    };
  },
  methods: {
    onSubmit() {
      Loading.show();
      // eslint-disable-next-line no-restricted-globals
      const url = new URL(location.href);
      url.pathname = this.$router.resolve({ name: 'Login' }).href;

      auth.sendPasswordResetEmail(this.form.email, { url: url.toString() })
        .then(() => Notify.create(`Email untuk reset password telah dikirim ke ${this.form.email}`))
        .catch((err) => Notify.create({ message: getErrMsg(err), type: 'negative' }))
        .finally(() => Loading.hide());
    },
  },
});
</script>

<style lang="scss" scoped>
.forgot-card {
  width: 100%;
  max-width: $breakpoint-xs;
}
</style>
