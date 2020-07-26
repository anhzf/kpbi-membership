<template>
<v-app id="inspire">

    <DrawerNavigation
        :drawer="drawer"
        :isLoggedIn="isLoggedIn"
        :userEmail="userEmail"
        :userName="userName"
        @logout="logout"
    ></DrawerNavigation>
    <NavigationBar @navigate="drawer = !drawer" @authenticate="authenticate"></NavigationBar>

    <v-main>
        <keep-alive>
            <router-view v-if="$route.meta.keepAlive"></router-view>
        </keep-alive>
        <router-view v-if="!$route.meta.keepAlive" @authenticate="authenticate"></router-view>
    </v-main>

    <PageFooter></PageFooter>

</v-app>
</template>

<script>
import DrawerNavigation from "./components/DrawerNavigation";
import PageFooter from "./components/PageFooter";
import NavigationBar from "./components/NavigationBar";
import authentication from "./util/authentication";


export default {
    data() {
        return {
            drawer: true,
            isLoggedIn: false,
            userId: null,
            userEmail: null,
            userName: null,
        }
    },


    methods: {
        async authenticate() {
            // console.log(await authentication());
            ({
                isLoggedIn: this.isLoggedIn,
                userId: this.userId,
                userEmail: this.userEmail,
                userName: this.userName,
            } = await authentication())
        },

        
        logout() {
            window.axios.post('/logout')
                .then(() => {
                    console.log('Logged Out!')
                    this.authenticate()
                    this.$router.push({name: 'Login'})
                })
        }
    },


    created() {
        this.authenticate()
    },


    components: {
        DrawerNavigation,
        NavigationBar,
        PageFooter,
    }
}
</script>
