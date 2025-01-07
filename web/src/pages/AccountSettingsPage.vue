<script lang="ts" setup>
import { Loading } from 'quasar';
import DefineState from 'components/DefineState.vue';
import userService from 'src/services/user';
import { useAuthStore } from 'src/stores/auth';
import { requiredRule, shouldEq } from 'src/utils/input-rules';
import { pageLoading, toastErrorIfAny, toastResponse } from 'src/utils/ui';
import {
  computed, onMounted, reactive, ref,
} from 'vue';

const DEFAULT_CHANGED_FIELDS = {
  name: '',
  email: '',
  phoneNumber: '',
};

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

const changedFields = ref(DEFAULT_CHANGED_FIELDS);
const resetChangedField = () => {
  changedFields.value = DEFAULT_CHANGED_FIELDS;
};

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

const onPhotoChange = async (ev: Event) => {
  const target = ev.target as HTMLInputElement;

  if (target.files?.length) {
    if (window.confirm('Apakah Anda yakin ingin mengubah foto profil?') === false) {
      target.value = '';
      return;
    }

    const file = target.files[0];

    await toastErrorIfAny(
      pageLoading(userService.updateProfile({ img: file })),
    );

    target.value = '';

    auth.refresh();
  }
};

const onSaveNameClick = async () => {
  if (!(changedFields.value.name !== auth.user?.name)) return;

  await toastResponse(
    pageLoading(userService.updateProfile({ name: changedFields.value.name })),
    'Berhasil memperbarui nama.',
  );

  auth.refresh();
  resetChangedField();
};

const onSaveEmailClick = async (value: string, initial: string) => {
  if (window.confirm('Apakah Anda yakin ingin mengubah email?') === false) return;
  if (!(value !== initial)) return;

  await toastResponse(
    pageLoading(userService.updateProfile({ email: value })),
    'Berhasil memperbarui email, harap verifikasi email ulang.',
  );

  auth.refresh();
  resetChangedField();
};

const onSavePhoneNumberClick = async (value: string, initial: string) => {
  if (!(value !== initial)) return;

  await toastResponse(
    pageLoading(userService.updateProfile({ phone_number: value })),
    'Berhasil memperbarui nomor hp.',
  );

  auth.refresh();
  resetChangedField();
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
      </q-list>

      <q-card-section class="flex flex-col">
        <q-avatar
          size="8rem"
          color="grey"
          class="group self-center"
        >
          <q-img :src="auth.user?.img" />

          <q-btn
            icon="upload"
            flat
            round
            class="opacity-0 group-hover:!opacity-100 absolute-full transition-opacity"
          >
            <label>
              <input
                type="file"
                accept="image/jpg, image/jpeg, image/png"
                class="absolute-full cursor-pointer opacity-0"
                @change="onPhotoChange"
              >
            </label>
          </q-btn>
        </q-avatar>

        <!-- TODO: Use QPopupEdit -->
        <DefineState
          :value="false"
          #="{state: [isEditMode, setEditMode]}"
        >
          <h6 class="relative self-center text-center flex items-center">
            <q-input
              v-if="isEditMode"
              :model-value="changedFields.name || auth.user?.name"
              label="Nama"
              dense
              @update:model-value="changedFields.name = ($event as string)"
            />
            <template v-else>
              {{ auth.user?.name }}
            </template>

            <div class="absolute left-full flex flex-nowrap">
              <template v-if="isEditMode">
                <q-btn
                  icon="close"
                  flat
                  round
                  color="negative"
                  @click="setEditMode(false)"
                />
                <q-btn
                  icon="check"
                  flat
                  round
                  color="positive"
                  :disabled="!(changedFields.name && (changedFields.name !== auth.user?.name))"
                  @click="onSaveNameClick().then(() => setEditMode(false))"
                />
              </template>

              <q-btn
                v-else
                icon="edit"
                flat
                round
                color="grey"
                @click="setEditMode(!isEditMode)"
              />
            </div>
          </h6>
        </DefineState>
      </q-card-section>

      <q-list
        v-if="auth.user"
        padding
      >
        <q-item>
          <q-item-section>
            <q-item-label>Email</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label>
              <div class="flex items-center gap-2">
                <q-btn
                  icon="edit"
                  flat
                  round
                >
                  <q-popup-edit
                    :model-value="changedFields.email || auth.user.email"
                    title="Perbarui email"
                    buttons
                    label-set="Simpan"
                    #="scope"
                    class="w-40ch"
                    @update:model-value="changedFields.email = $event"
                    @save="onSaveEmailClick"
                  >
                    <q-input
                      v-model="scope.value"
                      type="email"
                      dense
                      autofocus
                      @keyup.enter="scope.set"
                    />
                  </q-popup-edit>
                </q-btn>
                {{ auth.user.email }}
              </div>
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Nomor WhatsApp</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label>
              <div class="flex items-center gap-2">
                <q-btn
                  icon="edit"
                  flat
                  round
                >
                  <q-popup-edit
                    :model-value="changedFields.phoneNumber || auth.user.phone_number"
                    title="Perbarui nomor"
                    buttons
                    label-set="Simpan"
                    #="scope"
                    class="w-40ch"
                    @update:model-value="changedFields.phoneNumber = $event"
                    @save="onSavePhoneNumberClick"
                  >
                    <q-input
                      v-model="scope.value"
                      type="tel"
                      dense
                      autofocus
                      placeholder="Contoh: 6281234567890"
                      hint="Gunakan format internasional, contoh: 6281234567890"
                      @keyup.enter="scope.set"
                    />
                  </q-popup-edit>
                </q-btn>
                {{ auth.user.phone_number || 'Belum ada' }}
              </div>
            </q-item-label>
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
