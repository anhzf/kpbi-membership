import { Loading } from 'quasar';
import { boot } from 'quasar/wrappers';
import { auth } from 'src/firebaseService';
import type { RouteLocationRaw } from 'vue-router';
import type { StateInterface } from 'src/store';

export default boot<StateInterface>(({ store, router, urlPath }) => {
  const getCurrentRoute = (isFirstLoad = false) => (isFirstLoad
    ? router.resolve(urlPath)
    : router.currentRoute.value);
  const getRouteGuardType = (isFirstLoad = false) => getCurrentRoute(isFirstLoad).meta.guard || 'default';

  auth
    .onAuthStateChanged(
      (user) => {
        store.commit('auth/setUser', user);

        return user
          ? store.dispatch('auth/afterAuthenticated')
          : store.dispatch('auth/afterUnauthenticated');
      },
    );

  store.watch(
    (state) => [state.auth.user, state.auth.isWaiting] as const,
    // eslint-disable-next-line @typescript-eslint/no-misused-promises
    ([user], old) => {
      const isAuthenticated = Boolean(user);
      const isFirstLoad = old === undefined;
      const routeGuardType = getRouteGuardType(isFirstLoad);
      const to = ((): RouteLocationRaw => {
        if (routeGuardType === 'auth' && !isAuthenticated) {
          return { name: 'Login' };
        }
        if (routeGuardType === 'no-auth' && isAuthenticated) {
          return { name: 'Home' };
        }

        return urlPath;
      })();

      return !isFirstLoad && router.push(to);
    },
    { immediate: true },
  );

  store.watch(
    (state) => state.auth.isWaiting,
    (isWaiting, isWaitingOld) => {
      const isFirstLoad = isWaitingOld === undefined;
      const routeGuardType = getRouteGuardType(isFirstLoad);

      if (routeGuardType === 'auth') {
        return (isWaiting
          ? Loading.show({ message: 'Authenticating...' })
          : Loading.hide());
      }

      return undefined;
    },
    { immediate: true },
  );
});
