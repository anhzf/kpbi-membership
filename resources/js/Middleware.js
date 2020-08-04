import store from "@/store"

function guestOnly (to, from, next) {
    if (store.getters.isLoggedIn) next({ name: 'AccountSettings', query: {redirect: from.fullPath} })
    else next()
}

function auth (to, from, next) {
    if (store.getters.isLoggedIn) next()
    else next({ name: 'Login', query: {redirect: to.fullPath} })
}

function emailVerified (to, from, next) {
    if (store.getters.userVerified) next()
    else next({ name: 'AccountSettings', query: {redirect: to.fullPath} })
}


export {
    guestOnly, auth, emailVerified
}