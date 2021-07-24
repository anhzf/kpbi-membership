<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="account-settings-card">
      <q-list padding>
        <q-item :class="isVerified ? 'bg-green-1' : 'bg-red-1'">
          <q-item-section avatar>
            <q-icon
              :name="isVerified ? 'verified_user' : 'clear'"
              :color="isVerified ? 'positive' : 'negative'"
            />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ isVerified ? 'Terverifikasi' : 'Belum terverifikasi' }}</q-item-label>
          </q-item-section>
          <q-item-section
            v-if="!isVerified"
            side
          >
            <q-btn
              label="kirim email verifikasi sekarang"
              rounded
              unelevated
              size="sm"
              color="primary"
              @click="onSendEmailVerificationNow"
            />
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Email</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label>{{ $store.state.auth.user?.email }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Password</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label>
              <q-btn
                label="Ubah password"
                icon="edit"
                flat
                size="sm"
                @click="onChangePasswordClick"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';
import { Dialog, Loading, Notify } from 'quasar';
import DialogChangePassword from 'components/ui/AccountSettings/DialogChangePassword.vue';
import { useStore } from 'src/store';
import { auth } from 'src/firebaseService';
import { getErrMsg } from 'src/helpers';

export default defineComponent({
  name: 'PageAccountSettings',
  setup() {
    const store = useStore();
    const isVerified = computed(() => store.state.auth.user?.emailVerified);
    const openChangePasswordDialog = () => Dialog.create({
      component: DialogChangePassword,
    });

    return {
      isVerified,
      onChangePasswordClick: openChangePasswordDialog,
    };
  },
  methods: {
    onSendEmailVerificationNow() {
      const user = auth.currentUser;
      if (user) {
        Loading.show();
        // eslint-disable-next-line no-restricted-globals
        const url = new URL(location.href);
        url.pathname = this.$router.resolve({ name: 'AccountSettings' }).href;
        user.sendEmailVerification({
          url: url.toString(),
        })
          .then(() => Notify.create(`Email untuk verifikasi telah dikirim ke ${user.email!}`))
          .catch((err) => Notify.create({ message: getErrMsg(err), type: 'negative' }))
          .finally(() => Loading.hide());
      } else {
        Notify.create({ message: 'Please login first', type: 'negative' });
      }
    },
  },
});
</script>

<style lang="scss" scoped>
.account-settings-card {
  width: 100%;
  max-width: $breakpoint-xs;
}
</style>
