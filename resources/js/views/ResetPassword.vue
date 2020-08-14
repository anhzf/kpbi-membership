<template>
    <v-container fluid class="fill-height">

        <v-row justify="center" align="stretch">

            <v-card width="320" class="elevation-4 mb-16">
                <v-form
                    ref="resetPasswordForm"
                    @submit.prevent="resetPassword"
                    :disabled="formDisabled"
                >
                    
                    <v-card-title primary-title>Reset password</v-card-title>
                    <v-card-subtitle>Silahkan isi form berikut untuk mengganti password!</v-card-subtitle>

                    <v-card-text class="px-4">

                        <v-text-field
                            label="Email"
                            placeholder="user@example.com"
                            v-model="email"
                            outlined
                        />
                        <v-text-field
                            :type="showPassword ? 'text' : 'password'"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            label="Password Baru"
                            placeholder="password"
                            v-model="password"
                            outlined
                            @click:append="showPassword = !showPassword"
                        />
                        <v-text-field
                            :type="showPassword ? 'text' : 'password'"
                            label="Ulangi Password Baru"
                            placeholder="ulangi password"
                            v-model="password_confirmation"
                            outlined
                        />

                    </v-card-text>

                    <v-card-actions class="px-4">
                        <v-spacer></v-spacer>
                        <v-btn type="submit" color="primary" text>Submit</v-btn>
                    </v-card-actions>

                </v-form>
            </v-card>

        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'ResetPassword',
    data: () => ({
        email: null,
        password: null,
        password_confirmation: null,
        showPassword: false,
        formDisabled: false,
    }),
    methods: {
        async resetPassword() {
            this.$store.commit('contentLoading', true)
            this.formDisabled = true
            const resetData = {
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            }
            try {
                const reset = await window.axios.post(this.$route.fullPath, resetData)
                this.$emit('notice', {message: reset.data.message, type: 'success'})
                this.$router.push({name: 'AccountSettings'})
            } catch (err) {
                this.$emit('noticeError', err)
            }
            this.$refs.resetPasswordForm.reset()
            this.formDisabled = false
            this.$store.commit('contentLoading', false)
        }
    },
}
</script>