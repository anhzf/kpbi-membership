import { createGlobalState, useAsyncState } from '@vueuse/core';
import memberService from 'src/services/member';
import { watch } from 'vue';
import { useRoute } from 'vue-router';

const _useMemberProfile = () => {
  const route = useRoute();
  const { execute: refresh, ...returns } = useAsyncState(() => memberService.get(String(route.params.memberId)), undefined);

  watch(() => route.params.memberId, () => {
    refresh();
  });

  return returns;
};

export default createGlobalState(_useMemberProfile);
