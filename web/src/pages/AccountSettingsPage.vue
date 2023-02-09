<script lang="ts" setup>
import { Loading } from 'quasar';
import userService from 'src/services/user';
import { useAuthStore } from 'src/stores/auth';
import { computed, onMounted } from 'vue';

const auth = useAuthStore();
const isVerified = computed(() => !!auth.user?.email_verified_at);

const onSendEmailVerificationClick = async () => {
  try {
    Loading.show();
    await userService.sendEmailVerificationRequest();
  } finally {
    Loading.hide();
  }
};
const onChangePasswordClick = () => {
  //
};

onMounted(() => {
  auth.refresh();
});
</script>

<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="w-full max-w-screen-sm">
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
              size="sm"
              color="primary"
              @click="onSendEmailVerificationClick"
            />
          </q-item-section>
        </q-item>

        <q-item v-if="auth.user">
          <q-item-section>
            <q-item-label>Email</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label>{{ auth.user.email }}</q-item-label>
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
                dense
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
