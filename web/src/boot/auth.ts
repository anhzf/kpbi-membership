import { Loading } from 'quasar';
import { boot } from 'quasar/wrappers';
import { useAuthStore } from 'src/stores/auth';
import { GuardType } from 'src/types/common';
import { watch } from 'vue';
import { RouteLocationRaw } from 'vue-router';

const AUTH_FAIL_REDIRECT: RouteLocationRaw = { name: 'Login' };
const GUEST_FAIL_REDIRECT: RouteLocationRaw = { name: 'MyProfile' };

const inferRoute = (guard: GuardType, store: ReturnType<typeof useAuthStore>) => {
  switch (guard) {
    case 'auth':
      return !!store.user || AUTH_FAIL_REDIRECT;

    case 'guest':
      return !store.user || GUEST_FAIL_REDIRECT;

    default:
      return true;
  }
};

export default boot(({ router }) => {
  const auth = useAuthStore();

  auth.refresh();

  router.beforeEach((to) => {
    if (auth.isReady) {
      return inferRoute(to.meta.guard || 'default', auth);
    }

    return true;
  });

  watch(() => [auth, auth.isReady], async () => {
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
