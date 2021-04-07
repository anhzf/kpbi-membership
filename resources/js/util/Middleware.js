import store from "@/store"

function guestOnly (to, from, next, message = null) {
  if (store.getters.isLoggedIn) next({ name: 'AccountSettings', query: {redirect: from.fullPath, message} })
  else next()
}

function auth (to, from, next, message = 'Sebelum melanjutkan silahkan Login dulu...') {
  if (store.getters.isLoggedIn) next()
  else next({ name: 'Login', query: {redirect: to.fullPath, message} })
}

function emailVerified (to, from, next, message = null) {
  if (store.getters.userVerified) next()
  else next({ name: 'AccountSettings', query: {redirect: to.fullPath, message} })
}


export {
  guestOnly, auth, emailVerified
}
