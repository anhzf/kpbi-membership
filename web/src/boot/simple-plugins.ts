import { defineBoot } from '#q-app/wrappers';
import { QueryClient, VueQueryPlugin, type VueQueryPluginOptions } from '@tanstack/vue-query';

const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      refetchOnMount: false,
      refetchOnWindowFocus: false,
    },
  },
});

const vueQueryOptions: VueQueryPluginOptions = {
  queryClient,
};

export default defineBoot(({ app }) => {
  app.use(VueQueryPlugin, vueQueryOptions);
});
