<template>
  <v-dialog
    :value="value"
    @input="$emit('input', $event)"
    width="450"
    max-width="100%"
    :persistent="changePasswordOnProgress"
  >
    <v-card>
      <v-card-title v-if="!changePasswordOnProgress">Ubah Password</v-card-title>
      <v-card-text>
        <v-container fluid>
          <v-row justify="center" align="center">
            <v-progress-circular
              v-if="changePasswordOnProgress"
              :indeterminate="changePasswordOnProgress"
            />
            <v-col v-else>
              <v-form ref="changePasswordForm">
                <v-text-field
                  v-model="oldPassword"
                  label="Password Lama"
                  :type="showOldPassword ? 'text' : 'password'"
                  :append-icon="showOldPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  @click:append="showOldPassword = !showOldPassword"
                  :rules="[required]"
                />
                <v-text-field
                  v-model="newPassword"
                  label="Password baru"
                  :type="showNewPassword ? 'text' : 'password'"
                  :append-icon="showNewPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  @click:append="showNewPassword = !showNewPassword"
                  :rules="[required]"
                />
                <v-text-field
                  v-model="newPassword_confirmation"
                  label="Ulangi password baru"
                  :type="showNewPassword ? 'text' : 'password'"
                  :rules="[required]"
                />
              </v-form>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions v-if="!changePasswordOnProgress">
        <v-spacer/>
        <v-btn color="grey darken-1" text @click="$emit('input', false)">Close</v-btn>
        <v-btn color="blue darken-1" text @click="changePassword">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { required } from '@/util/Validator';

export default {
  name: 'ChangePasswordDialog',
  props: {
    value: {
      required: true,
      type: Boolean,
    },
  },
  data: () => ({
    changePasswordOnProgress: false,
    oldPassword: null,
    showOldPassword: null,
    newPassword: null,
    showNewPassword: null,
    newPassword_confirmation: null,
    required
  }),
  methods: {
    async changePassword() {
      this.changePasswordOnProgress = true
      const changePassword = {
        oldPassword: this.oldPassword,
        newPassword: this.newPassword,
        newPassword_confirmation: this.newPassword_confirmation
      }

      this.$refs.changePasswordForm.reset()
      this.$refs.changePasswordForm.resetValidation()

      try {
        const {data: {message}} = await window.axios.put('/api/auth/user/change-password', changePassword)
        this.$emit('notice', {message, type: 'success'})
      } catch (err) {
          this.$emit('noticeError', err)
      }
      this.$emit('input', false)
      this.changePasswordOnProgress = false
    },
  },
  // watch: {
    // toggleChangePassword() {
    //   if (!this.toggleChangePassword) {
    //     this.$refs.changePasswordForm.reset()
    //     this.$refs.changePasswordForm.resetValidation()
    //   }
    // }
  // }

}
</script>

<style>

</style>
