import type { ActionTree } from 'vuex';
import type { StateInterface } from '../index';
import type { AuthStateInterface } from './state';

const actions: ActionTree<AuthStateInterface, StateInterface> = {
  afterAuthenticated(ctx) {
    Promise.resolve(ctx.state.afterLoginFn?.())
      .finally(() => {
        ctx.commit('setAfterLoginFn', null);
        ctx.commit('setIsWaiting', false);
      });
  },
  afterUnauthenticated(ctx) {
    Promise.resolve(ctx.state.afterLogoutFn?.())
      .finally(() => {
        ctx.commit('setAfterLogoutFn', null);
        ctx.commit('setIsWaiting', false);
      });
  },
};

export default actions;
