import { MutationTree } from 'vuex';
import type { Vuex } from 'src/types';
import { AuthStateInterface } from './state';

const mutation: MutationTree<AuthStateInterface> = {
  setUser(state, payload: AuthStateInterface['user']) {
    state.user = payload;
  },
  authResolved(state) {
    if (state.isWaiting) {
      state.isWaiting = false;
    }
  },
};

export type AuthMutationInterface = Vuex.MutationFns<{
  setUser: AuthStateInterface['user'];
}>

export default mutation;
