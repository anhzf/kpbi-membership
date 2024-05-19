import { createGlobalState, useAsyncState, whenever } from '@vueuse/core';
import { AxiosError } from 'axios';
import { Notify } from 'quasar';
import memberService from 'src/services/member';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const _useMemberProfile = () => {
  const route = useRoute();
  const { execute: refresh, ...returns } = useAsyncState(
    () => memberService.get(String(route.params.memberId)),
    undefined,
    {
      onError: (err) => {
        if ((err instanceof AxiosError)
          && (err.response?.status === 401)) {
          Notify.create({
            type: 'negative',
            message: 'Silakan login terlebih dahulu',
            actions: [
              {
                label: 'Login',
                color: 'white',
                to: { name: 'Login' },
              },
            ],
          });
        }
      },
    },
  );

  whenever(() => route.params.memberId, () => {
    refresh();
  });

  return { ...returns, refresh };
};

export const useIsMemberItself = () => {
  const route = useRoute();
  const isOwner = computed(() => route.params.memberId === 'me');
  return isOwner;
};

export default createGlobalState(_useMemberProfile);
