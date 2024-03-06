import { ref } from 'vue';

export const useLoading = (init = false) => {
  const state = ref(init);
  const start = <T>(promise: Promise<T>) => {
    state.value = true;
    return promise.finally(() => {
      state.value = false;
    });
  };

  return [state, start] as const;
};
