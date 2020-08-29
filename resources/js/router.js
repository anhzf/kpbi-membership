import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'
// use import() instead of default import statement to make lazy router-views 
const Member = () => import('./views/Member.vue')
const Login = () => import('./views/Login.vue')
const ForgotPassword = () => import('./views/ForgotPassword.vue')
const ResetPassword = () => import('./views/ResetPassword.vue')
const Register = () => import('./views/Register.vue')
const Verify = () => import('./views/Verify.vue')
const MyProfile = () => import('./views/MyProfile.vue')
const AccountSettings = () => import('./views/AccountSettings.vue')
const Admin = () => import('./views/Admin.vue')
const NotFound404 = () => import('./views/404.vue')
// Middleware
import {auth, emailVerified , guestOnly} from './util/Middleware'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',

    routes: [
        {
            name: 'Members',
            path: '/members',
            alias: '/',
            component: Member,
        },
        {
            name: 'Login',
            path: '/login',
            component: Login,
            beforeEnter: guestOnly,
        },
        {
            name: 'ForgotPassword',
            path: '/forgot-password',
            component: ForgotPassword,
            beforeEnter: guestOnly,
        },
        {
            name: 'ResetPassword',
            path: '/reset/:hashed?',
            component: ResetPassword,
            beforeEnter: guestOnly,
        },
        {
            name: 'Register',
            path: '/daftar',
            component: Register,
            beforeEnter: guestOnly,
        },
        {
            name: 'Verify',
            path: '/verify/:id?',
            component: Verify,
            beforeEnter: auth,
        },
        {
            name: 'MyProfile',
            path: '/profil-saya',
            component: MyProfile,
            beforeEnter: emailVerified,
        },
        {
            name: 'AccountSettings',
            path: '/settings',
            component: AccountSettings,
            beforeEnter: auth,
        },
        {
            name: 'Admin',
            path: '/admin',
            component: Admin,
            beforeEnter: auth,
        },
        {
            name: '404',
            path: '/404',
            component: NotFound404
        },
        {
            path: '*',
            redirect: '404'
        },
    ]
})

router.beforeEach(async (to, from, next) => {
    store.commit('contentLoading', true)
    await store.dispatch('authenticate')
    next()
})
router.afterEach((to, from) => {
    store.commit('contentLoading', false)
})

export default router