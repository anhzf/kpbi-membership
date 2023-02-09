<script lang="ts" setup>
import { Loading } from 'quasar';
import userService from 'src/services/user';
import { useAuthStore } from 'src/stores/auth';
import { requiredRule, shouldEq } from 'src/utils/input-rules';
import { computed, onMounted, reactive } from 'vue';

const _ui = reactive({
  showChangePasswordDialog: false,
});
const auth = useAuthStore();
const isVerified = computed(() => !!auth.user?.email_verified_at);
const changePasswordField = reactive({
  currentPassword: '',
  newPassword: '',
  newPasswordConfirmation: '',
});

const onSendEmailVerificationClick = async () => {
  try {
    Loading.show();
    await userService.sendEmailVerificationRequest();
  } finally {
    Loading.hide();
  }
};
const onChangePasswordClick = () => {
  _ui.showChangePasswordDialog = true;
};

const onChangePasswordFormReset = () => {
  changePasswordField.currentPassword = '';
  changePasswordField.newPassword = '';
  changePasswordField.newPasswordConfirmation = '';
};

const onChangePasswordFormSubmit = async () => {
  try {
    Loading.show();
    await userService.changePassword({
      current_password: changePasswordField.currentPassword,
      password: changePasswordField.newPassword,
      password_confirmation: changePasswordField.newPasswordConfirmation,
    });

    _ui.showChangePasswordDialog = false;
  } finally {
    Loading.hide();
    onChangePasswordFormReset();
  }
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
                flat
                @click="onChangePasswordClick"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>
  </q-page>

  <q-dialog v-model="_ui.showChangePasswordDialog">
    <q-card class="w-full max-w-screen-sm">
      <q-form
        @submit="onChangePasswordFormSubmit"
        @reset="onChangePasswordFormReset"
      >
        <q-card-section class="row items-center">
          <q-avatar icon="lock" />
          <div class="text-h6">
            Ubah password
          </div>
        </q-card-section>

        <q-card-section>
          <q-input
            v-model="changePasswordField.currentPassword"
            label="Password saat ini"
            type="password"
            :rules="[requiredRule]"
            autofocus
          />
          <q-input
            v-model="changePasswordField.newPassword"
            label="Password baru"
            type="password"
            :rules="[requiredRule]"
          />
          <q-input
            v-model="changePasswordField.newPasswordConfirmation"
            label="Konfirmasi password baru"
            type="password"
            :rules="[shouldEq('Password baru', changePasswordField.newPassword)]"
          />
        </q-card-section>

        <q-card-actions align="right">
          <q-btn
            label="Batal"
            flat
            color="primary"
            v-close-popup
          />
          <q-btn
            label="Simpan"
            type="submit"
            color="primary"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
