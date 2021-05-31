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
import { Dialog } from 'quasar';
import DialogChangePassword from 'components/ui/AccountSettings/DialogChangePassword.vue';
import { useStore } from 'src/store';

export default defineComponent({
  name: 'PageAccountSettings',
  setup() {
    const store = useStore();
    const openChangePasswordDialog = () => Dialog.create({
      component: DialogChangePassword,
    });

    return {
      isVerified: computed(() => store.state.auth.user?.emailVerified),
      onChangePasswordClick: openChangePasswordDialog,
    };
  },
});
</script>

<style lang="scss" scoped>
.account-settings-card {
  width: 100%;
  max-width: $breakpoint-xs;
}
</style>
