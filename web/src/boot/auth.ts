import { watch } from 'vue';
import { RouteLocationRaw } from 'vue-router';
import { boot } from 'quasar/wrappers';
import { useAuthStore } from 'src/stores/auth';
import { GuardType } from 'src/types/common';
import { Loading } from 'quasar';

const AUTH_FAIL_REDIRECT: RouteLocationRaw = { name: 'Login' };
const NOAUTH_FAIL_REDIRECT: RouteLocationRaw = { name: 'Home' };

const inferRoute = (guard: GuardType, store: ReturnType<typeof useAuthStore>) => {
  switch (guard) {
    case 'auth':
      return store.isAuthenticated || AUTH_FAIL_REDIRECT;

    case 'no-auth':
      return !store.isAuthenticated || NOAUTH_FAIL_REDIRECT;

    default:
      return true;
  }
};

export default boot(({ router }) => {
  const auth = useAuthStore();
  void auth.validate();

  router.beforeEach((to) => (auth.isReady
    ? inferRoute(to.meta.guard || 'default', auth)
    : true));

  watch(() => [auth.isAuthenticated, auth.isReady], async () => {
    if (auth.isReady) {
      const routeShouldBe = inferRoute(router.currentRoute.value.meta.guard || 'default', auth);

      if (typeof routeShouldBe !== 'boolean') {
        await router.push(routeShouldBe);
      }
    }
  });

  watch(() => auth.isReady, () => {
    if (auth.isReady) Loading.hide();
    else {
      Loading.show({
        message: 'Authenticating...',
      });
    }
  }, { immediate: true });
});
