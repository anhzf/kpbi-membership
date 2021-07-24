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
          class="columns q-gutter-md"
          @submit="onSubmit"
        >
          <div class="row gap-x-sm">
            <q-select
              v-model="form.jenjang"
              label="Jenjang"
              outlined
              :options="['S1', 'S2', 'S3']"
              :rules="[requiredRule]"
              class="col-3"
            />

            <q-input
              v-model="form.namaProdi"
              label="Nama Prodi"
              outlined
              :rules="[requiredRule]"
              class="col-grow"
            />
          </div>

          <div class="row gap-x-sm">
            <small class="col-12 q-pl-sm text-weight-medium text-grey">NAMA PERGURUAN TINGGI</small>
            <q-input
              v-model="form.perguruanTinggi.singkatan"
              label="Singkat"
              outlined
              :rules="[requiredRule]"
              class="col-shrink"
            />
            <q-input
              v-model="form.perguruanTinggi.lengkap"
              label="Lengkap"
              outlined
              :rules="[requiredRule]"
              class="col-grow"
            />
          </div>

          <q-input
            v-model="form.emailProdi"
            label="Email prodi"
            type="email"
            outlined
            :rules="[requiredRule]"
          />

          <q-input
            v-model="form.kaprodi.email"
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

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import { Dialog, Loading, Notify } from 'quasar';
import { useStore } from 'src/store';
import { auth } from 'src/firebaseService';
import services from 'src/firestoreServices';
import DialogChangePassword from 'components/ui/AccountSettings/DialogChangePassword.vue';
import { requiredRule } from 'src/inputRules';
import { getErrMsg } from 'src/helpers';
import { isValidMemberRegisterRequire } from 'app/common/schema';
import type { MemberRegisterRequire } from 'app/common/schema';

const defaultPassword = 'imNewKPBIMember';

export default defineComponent({
  name: 'PageRegister',
  setup() {
    const formData = reactive<MemberRegisterRequire>({
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
    const store = useStore();
    const register = () => {
      if (isValidMemberRegisterRequire(formData)) {
        store.commit('auth/setAfterLoginFn', () => {
          Dialog.create({
            component: DialogChangePassword,
            componentProps: { token: defaultPassword },
          });
          Notify.create({ message: 'Mohon untuk langsung mengganti password', timeout: 60 * 1000 });
        });

        auth.createUserWithEmailAndPassword(formData.kaprodi.email, defaultPassword)
          .then(({ user }) => services.registerMember(user!, formData))
          .catch((err) => Notify.create({ message: getErrMsg(err), type: 'negative' }));
      } else {
        Notify.create({ message: 'Data registrasi tidak memenuhi', type: 'negative' });
      }
    };

    return {
      form: formData,
      register,
      // utils
      requiredRule,
    };
  },
  methods: {
    onSubmit() {
      Loading.show();
      this.$store.commit('auth/setIsWaiting', true);
      Promise.resolve(this.register())
        .finally(() => Loading.hide());
    },
  },
});
</script>

<style lang="scss" scoped>
.register-card {
  width: 100%;
  max-width: $breakpoint-xs;
}
</style>
