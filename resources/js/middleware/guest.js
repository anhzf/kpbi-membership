import store from "../store"

export default function (to, from, next) {
    if (store.getters.isLoggedIn) next({name: 'MyProfile'})
    else next()
}
