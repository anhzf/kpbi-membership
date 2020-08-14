<template>
    <v-container fluid class="fill-height">

        <v-row justify="center" align="stretch">

            <v-card width="320" class="elevation-4 mb-16">
                <v-form
                    ref="ForgotPasswordForm"
                    @submit.prevent="resetPassword"
                    :disabled="formDisabled"
                >
                    
                    <v-card-title primary-title>Lupa password</v-card-title>
                    <v-card-subtitle>Silahkan isi identitas akun member anda untuk lakukan reset password</v-card-subtitle>

                    <v-card-text class="px-4">

                        <v-text-field
                            label="Username"
                            placeholder="(ex. S2 PBIO UNS)"
                            v-model="username"
                            outlined
                        />
                        <v-text-field
                            label="Email"
                            placeholder="user@example.com"
                            v-model="email"
                            outlined
                        />

                    </v-card-text>

                    <v-card-actions class="px-4">
                        <router-link :to="{name: 'Login'}" class="text-caption">Kembali ke halaman Login</router-link>
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
    name: 'ForgotPassword',
    data: () => ({
        username: null,
        email: null,
        formDisabled: false,
    }),
    methods: {
        async resetPassword() {
            this.$store.commit('contentLoading', true)
            this.formDisabled = true
            const userData = {
                username: this.username,
                email: this.email,
            }
            try {
                const reset = await window.axios.post('/api/forgot-password', userData)
                this.$emit('notice', {message: reset.data.message, type: 'success'})
            } catch (err) {
                this.$emit('noticeError', err)
            }
            this.$refs.ForgotPasswordForm.reset()
            this.formDisabled = false
            this.$store.commit('contentLoading', false)
        }
    }
}
</script>
