require('./bootstrap')

import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'

import store from './store'
import router from './router'


window.app = new Vue({
    router,
    store,
    vuetify,
    render: h => h(App)
}).$mount('#app')