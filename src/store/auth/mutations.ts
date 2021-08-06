import type { MutationTree } from 'vuex';
import type { Vuex } from 'src/types';
import type { AuthStateInterface } from './state';

const mutation: MutationTree<AuthStateInterface> = {
  setUser(state, payload: AuthStateInterface['user']) {
    state.user = payload;
  },
  setIsAdmin(state, payload: AuthStateInterface['isAdmin']) {
    state.isAdmin = payload;
  },
  setIsWaiting(state, payload: AuthStateInterface['isWaiting']) {
    state.isWaiting = payload;
  },
  setAfterLoginFn(state, payload: AuthStateInterface['afterLoginFn']) {
    state.afterLoginFn = payload;
  },
  setAfterLogoutFn(state, payload: AuthStateInterface['afterLogoutFn']) {
    state.afterLogoutFn = payload;
  },
};

export type AuthMutationInterface = Vuex.MutationFns<{
  setUser: AuthStateInterface['user'];
  setIsWaiting: AuthStateInterface['isWaiting'];
  setIsAdmin: AuthStateInterface['isAdmin'];
  setAfterLoginFn: AuthStateInterface['afterLoginFn'];
  setAfterLogoutFn: AuthStateInterface['afterLogoutFn'];
}>

export default mutation;
