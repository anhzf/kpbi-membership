<template>

    <v-navigation-drawer v-model="drawer" app class="elevation2">
        <v-system-bar color="light-green lighten-2"></v-system-bar>

        <v-list>
            
            <v-list-item>
                <v-list-item-avatar>
                    <v-img src="./img/ICON_KPBI.png"></v-img>
                </v-list-item-avatar>
                <v-list-item-content v-if="!isLoggedIn">
                    <v-list-item-title>KPBI</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item v-if="isLoggedIn">
                <v-list-item-content>
                    <v-list-item-title class="title">{{ userName }}</v-list-item-title>
                    <v-list-item-subtitle>{{ userEmail }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

        </v-list>

        <v-divider></v-divider>

        <v-list dense>

            <v-list-item v-if="!isLoggedIn" link :to="{name: 'Login'}">
                <v-list-item-action>
                    <v-icon>mdi-login-variant</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Login</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item v-if="!isLoggedIn" link>
                <v-list-item-action>
                    <v-icon>mdi-account-plus</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Register</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item v-if="isLoggedIn" link :to="{name: 'MyProfile'}">
                <v-list-item-action>
                    <v-icon>mdi-account</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Profil Saya</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item v-if="isLoggedIn" link :to="{name: 'AccountSettings'}">
                <v-list-item-action>
                    <v-icon>mdi-settings</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Pengaturan Akun</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item v-if="isLoggedIn" @click.stop="$emit('logout')">
                <v-list-item-action>
                    <v-icon>mdi-exit-to-app</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list-item link :to="{name: 'Members'}">
                <v-list-item-action>
                    <v-icon>mdi-account-multiple</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Anggota KPBI</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

        </v-list>

    </v-navigation-drawer>

</template>

<script>
export default {
    name: 'DrawerNavigation',


    props: {
        drawer: Boolean,
        isLoggedIn: Boolean,
        userName: {
            type: String,
            required: false,
        },
        userEmail: {
            type: String,
            required: false,
        }
    },
}
</script>
