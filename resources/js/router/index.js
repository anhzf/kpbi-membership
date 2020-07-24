import Vue from 'vue'
import VueRouter from 'vue-router'
import Member from '../views/Member.vue'
import Login from '../views/Login.vue'

Vue.use(VueRouter)

// const baseURI = window.document.baseURI + 'new/'

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/',
            redirect: 'members'
        },
        {
            name: 'Members',
            path: '/members',
            component: Member,
            meta: {
                keepAlive: true
            }
        },
        {
            name: 'Login',
            path: '/login',
            component: Login
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