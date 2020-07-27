<template>
<v-app>

    <DrawerNavigation
        :drawer="drawer"
        :isLoggedIn="isLoggedIn"
        :userEmail="userEmail"
        :userName="userName"
        @logout="logout"
    ></DrawerNavigation>
    <NavigationBar @navigate="drawer = !drawer" :contentLoading="isContentLoading"></NavigationBar>

    <v-main>
        <keep-alive>
            <router-view v-if="$route.meta.keepAlive" @login="login" @contentLoading="isContentLoading = $event"></router-view>
        </keep-alive>
        <router-view v-if="!$route.meta.keepAlive" @login="login" @contentLoading="isContentLoading = $event"></router-view>
    </v-main>

    <!-- <PageFooter></PageFooter> -->

</v-app>
</template>

<script>
import DrawerNavigation from "./components/DrawerNavigation";
import PageFooter from "./components/PageFooter";
import NavigationBar from "./components/NavigationBar";
import authentication from "./util/authentication";
import hardRedirect from "./util/hardRedirect";

export default {
    data() {
        return {
            drawer: true,
            isContentLoading: false,
            isLoggedIn: false,
            userId: null,
            userEmail: null,
            userName: null,
        }
    },


    methods: {
        async authenticate() {
            ({
                isLoggedIn: this.isLoggedIn,
                userId: this.userId,
                userEmail: this.userEmail,
                userName: this.userName,
            } = await authentication)
        },

        
        login(data) {
            this.isContentLoading = true

            const loginData = {
                name: data.username,
                password: data.password,
                _token: document.querySelector('meta[name=csrf-token]').content,
            }

            window.axios.post('/login', loginData)
                .then(() => {
                    hardRedirect(this, {name: 'MyProfile'})
                    this.isContentLoading = false
                })
        },


        logout() {
            this.isContentLoading = true

            window.axios.post('/logout')
                .then(() => {
                    hardRedirect(this, {name: 'Login'})
                    this.isContentLoading = false
                })
        }
    },


    created() {
        this.authenticate()
    },


    watch: {
        $route() {
            this.isContentLoading = false
        }
    },


    components: {
        DrawerNavigation,
        NavigationBar,
        PageFooter,
    }
}
</script>
