<template>
<v-row
    align="center"
    justify="center"
    class="pa-10"
>
    <v-card width="100%" max-width="650">
        <v-list>
            <v-list-item :class="[verified ? 'success':'error', 'lighten-5', 'pa-4']">
                <v-list-item-avatar>
                    <v-icon v-if="verified" color="success">mdi-check</v-icon>
                    <v-icon v-else color="error">mdi-close</v-icon>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title v-if="verified">Terverifikasi</v-list-item-title>
                    <v-list-item-title v-else>Belum terverifikasi</v-list-item-title>
                    <v-list-item-subtitle v-if="!verified">
                        <v-btn text x-small @click="sendEmailVerification">Kirim email verifikasi</v-btn>
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple>
                <v-list-item-content>
                    <v-row class="px-6">
                        <v-col sm="3" class="grey--text text--darken-1">Email</v-col>
                        <v-col class="text-right grey--text">{{ $store.getters.userEmail }}</v-col>
                    </v-row>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple>
                <v-list-item-content>
                    <v-row class="px-6">
                        <v-col sm="3" class="grey--text text--darken-1">Username</v-col>
                        <v-col class="text-right">{{ $store.getters.userName }}</v-col>
                    </v-row>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-row class="px-6" align="center">
                        <v-col sm="3" class="grey--text text--darken-1">Password</v-col>
                        <v-col class="text-right">
                            <v-btn
                                text small
                                color="grey darken-2"
                                @click="showChangePasswordDialog = !showChangePasswordDialog"
                            >
                                <v-icon small>mdi-pencil</v-icon>
                                Ubah password
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-card>
    <change-password-dialog
        v-model="showChangePasswordDialog"
        @notice="$emit('notice', $event)"
        @noticeError="$emit('noticeError', $event)"
    />
</v-row>
</template>

<script>
import ChangePasswordDialog from "@/components/ChangePasswordDialog";
import { required } from '@/util/Validator';

export default {
    name: 'AccountSettings',
    data: () => ({
        showChangePasswordDialog: false,
    }),
    computed: {
        verified() { return this.$store.getters.userVerified }
    },
    methods: {
        async sendEmailVerification() {
            this.$store.commit('contentLoading', true)
            try {
                const {data: {message}} = await window.axios('/verify/resend')
                this.$emit('notice', {message, type: 'success'})
            } catch (err) {
                this.$emit('noticeError', err)
            }
            this.$store.commit('contentLoading', false)
        },
    },
    components: {
        ChangePasswordDialog
    }
}
</script>