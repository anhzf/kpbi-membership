<template>

    <v-navigation-drawer v-model="drawer" app>
        <v-system-bar color="indigo lighten-1"></v-system-bar>

        <v-list>
            
            <v-list-item>
                <v-list-item-avatar>
                    <v-img src="./img/ICON_KPBI.png"></v-img>
                </v-list-item-avatar>
            </v-list-item>

            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">S1 PBIO UNS</v-list-item-title>
                    <v-list-item-subtitle>lorem.ipsum@kpbi.or.id</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

        </v-list>

        <v-divider></v-divider>

        <v-list dense>

            <v-list-item link :to="{name: 'Login'}">
                <v-list-item-action>
                    <v-icon>mdi-login-variant</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>Login</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

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
        drawer: Boolean
    }
}
</script>
