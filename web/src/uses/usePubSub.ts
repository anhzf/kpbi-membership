import { ref, onUnmounted } from 'vue';
import { PubSub } from 'app/utils/PubSub';

export const usePubSub = <T>(pubsub: PubSub<T>) => {
  const data = ref<T>(pubsub.value);

  type TData = typeof data.value;

  const unsubscribe = pubsub.subscribe((payload) => {
    data.value = payload as TData;
  });

  onUnmounted(unsubscribe);

  return data;
};
