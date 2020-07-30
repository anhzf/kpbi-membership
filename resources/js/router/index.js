import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
// use import() instead of default import statement to make lazy router-views 
const Member = () => import('../views/Member.vue')
const Login = () => import('../views/Login.vue')
const Register = () => import('../views/Register.vue')
const MyProfile = () => import('../views/MyProfile.vue')
const AccountSettings = () => import('../views/AccountSettings.vue')
const NotFound404 = () => import('../views/404.vue')
// Middleware
import auth from '../middleware/auth'
import guestOnly from '../middleware/guest'

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
            name: 'Register',
            path: '/daftar',
            component: Register,
            beforeEnter: guestOnly,
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
// router.before
router.afterEach((to, from) => {
    store.commit('contentLoading', false)
})

export default router