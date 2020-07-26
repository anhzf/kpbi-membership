import Vue from 'vue'
import VueRouter from 'vue-router'
import Member from '../views/Member.vue'
import Login from '../views/Login.vue'
import MyProfile from "../views/MyProfile.vue"
import AccountSettings from "../views/AccountSettings.vue";
// Middleware
import auth from "../middleware/auth"
import guest from "../middleware/guest"

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',

    routes: [
        // {
        //     path: '/',
        //     redirect: 'members',
        // },
        {
            name: 'Members',
            path: '/members',
            alias: '/',
            component: Member,
            meta: { keepAlive: true},
        },
        {
            name: 'Login',
            path: '/login',
            component: Login,
            beforeEnter: guest,
        },
        {
            name: 'MyProfile',
            path: '/profil-saya',
            component: MyProfile,
            beforeEnter: auth,
        },
        {
            name: 'AccountSettings',
            path: '/settings',
            component: AccountSettings,
            beforeEnter: auth,
        },
        {
            name: 'Register',
            path: '/daftar',
            component: MyProfile,
        },
        // {
        //     name: '404',
        //     path: '/404',
        //     component: NotFound404
        // },
        // {
        //     path: '*',
        //     redirect: '404'
        // },
    ]
})