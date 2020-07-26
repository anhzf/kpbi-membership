require('./bootstrap')
window.Vue = require('vue')


import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'


window.app = new Vue({
    router,
    vuetify,
    render: h => h(App)
}).$mount('#app')
