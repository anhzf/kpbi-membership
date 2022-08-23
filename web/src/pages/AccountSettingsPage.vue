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

<script lang="ts" setup>
import { ref } from 'vue';
import { useAuthStore } from 'src/stores/auth';

const auth = useAuthStore();
const isVerified = ref(false);

const onSendEmailVerificationClick = () => {
  //
};
const onChangePasswordClick = () => {
  //
};
</script>
