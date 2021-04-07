import Vue from "vue";
import Vuex from "vuex";

import authentication from "./util/authentication";

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    Authentication: {
      isLoggedIn: false,
      id: null,
      name: null,
      email: null,
      verified: null,
    },
    isContentLoading: false,
    csrfToken: document.querySelector('meta[name=csrf-token]').content,
  },
  mutations: {
    authenticate(state, data) {
      state.Authentication = data
    },
    contentLoading(state, data) {
      state.isContentLoading = data
    }
  },
  actions: {
    async authenticate({commit}) {
      commit('authenticate', await authentication())
    }
  },
  getters: {
    isLoggedIn: state => state.Authentication.isLoggedIn,
    userId: state => state.Authentication.id,
    userEmail: state => state.Authentication.email,
    userName: state => state.Authentication.name,
    userVerified: state => state.Authentication.verified,
    userRole: state => state.Authentication.role,
  }
})

export default store
