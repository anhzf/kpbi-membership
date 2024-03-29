import { createGlobalState, useAsyncState } from '@vueuse/core';
import { AxiosError } from 'axios';
import { Notify } from 'quasar';
import memberService from 'src/services/member';
import { watch } from 'vue';
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

  watch(() => route.params.memberId, () => {
    refresh();
  });

  return returns;
};

export default createGlobalState(_useMemberProfile);
