<template>
  <q-dialog
    ref="dialogRef"
    persistent
    @hide="onDialogHide"
  >
    <q-card class="q-dialog-plugin">
      <q-card-section>
        <h6>Ubah password</h6>
      </q-card-section>

      <q-card-section class="q-pb-lg">
        <q-form
          :id="`${$.uid}__formChangePassword`"
          @submit.prevent="onSubmit"
        >
          <q-input
            v-model="oldPassword"
            label="Password lama"
            :type="oldPasswordHide ? 'password' : 'text'"
            :rules="[requiredRule, isOldPasswordValidRule]"
            lazy-rules="ondemand"
          >
            <template
              v-if="token === ''"
              #append
            >
              <q-icon
                :name="oldPasswordHide ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="oldPasswordHide = !oldPasswordHide"
              />
            </template>
          </q-input>

          <q-input
            v-model="newPassword"
            label="Password baru"
            :type="newPasswordHide ? 'password' : 'text'"
            :rules="[requiredRule]"
          >
            <template #append>
              <q-icon
                :name="newPasswordHide ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="newPasswordHide = !newPasswordHide"
              />
            </template>
          </q-input>

          <q-input
            v-model="newPasswordConfirm"
            label="Konfirmasi password baru"
            :type="newPasswordHide ? 'password' : 'text'"
            :rules="[requiredRule, passwordConfirmationRule]"
          />
        </q-form>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn
          v-if="token === ''"
          color="primary"
          label="Cancel"
          @click="onCancelClick"
        />
        <q-btn
          label="Ubah Password"
          type="submit"
          color="blue-grey"
          flat
          :form="`${$.uid}__formChangePassword`"
        />
      </q-card-actions>

      <q-inner-loading :showing="isLoading">
        <q-circular-progress
          indeterminate
          size="md"
          color="primary"
        />
      </q-inner-loading>
    </q-card>
  </q-dialog>
</template>

<script lang="ts">
import {
  defineComponent, reactive, toRefs,
} from 'vue';
import { Notify, useDialogPluginComponent } from 'quasar';
import fbs, { auth } from 'src/firebaseService';
import { getErrMsg } from 'src/helpers';
import { requiredRule } from 'src/inputRules';

export default defineComponent({
  props: {
    token: {
      type: String,
      default: '',
    },
  },
  emits: useDialogPluginComponent.emits,
  setup(props) {
    const {
      dialogRef, onDialogHide, onDialogOK, onDialogCancel,
    } = useDialogPluginComponent();
    const state = reactive({
      oldPassword: props.token,
      newPassword: '',
      newPasswordConfirm: '',
      oldPasswordHide: true,
      newPasswordHide: true,
      isLoading: false,
    });
    const passwordConfirmationRule = (v: string) => (v === state.newPassword)
      || 'Password konfirmasi harus sama dengan password baru';
    const isOldPasswordValidRule = async (v: string) => {
      try {
        const user = auth.currentUser;
        if (user) {
          const credential = fbs.auth.EmailAuthProvider.credential(
            user.email!, v,
          );

          await user.reauthenticateWithCredential(credential);

          return true;
        }
        Notify.create('Unauthenticated');
        return 'Please login';
      } catch (err) {
        return getErrMsg(err);
      }
    };

    return {
      dialogRef,
      onDialogHide,
      onSubmit() {
        state.isLoading = true;
        auth.currentUser?.updatePassword(state.newPassword)
          .then(() => Notify.create({ message: 'Password berhasil diubah!', type: 'positive' }))
          .catch((err) => Notify.create({ message: getErrMsg(err, true), type: 'negative' }))
          .finally(() => onDialogOK());
      },
      onCancelClick: onDialogCancel,

      ...toRefs(state),
      requiredRule,
      passwordConfirmationRule,
      isOldPasswordValidRule,
    };
  },
});
</script>
