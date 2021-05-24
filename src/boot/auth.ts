import { Loading } from 'quasar';
import { boot } from 'quasar/wrappers';
import { auth } from 'src/firebaseService';
import type { Store } from 'vuex';
import type { StateInterface } from 'src/store';
import type { GuardType } from 'src/types';

export default boot(({ store, router, redirect }) => {
  auth
    .onAuthStateChanged(
      (user) => {
        store.commit('auth/authResolved');
        store.commit('auth/setUser', user);
      },
    );

  (store as Store<StateInterface>)
    .watch(
      (state) => state.auth.user,
      (user) => {
        const routeGuardType = (router.currentRoute.value.meta.guard || 'default') as GuardType;

        if (routeGuardType === 'auth' && !user) {
          return redirect({ name: 'Login' });
        }
        if (routeGuardType === 'no-auth' && user) {
          return redirect({ name: 'Home' });
        }

        return undefined as void;
      },
    );

  (store as Store<StateInterface>)
    .watch(
      (state) => state.auth.isWaiting,
      (isWaiting) => (isWaiting
        ? Loading.show({ message: 'Authenticating...' })
        : Loading.hide()),
      { immediate: true },
    );
});
