<script lang="ts" setup>
import { useVueToPrint } from 'vue-to-print';
import { computed, onBeforeMount, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const landscape = computed(() => route.meta.landscape);

const componentRef = ref();
const { handlePrint } = useVueToPrint({
  content: componentRef,
});

onBeforeMount(() => {
  window.readyToPrint ??= handlePrint;
});
</script>

<template>
  <div
    ref="componentRef"
    :class="['root p-1', landscape ? 'w-297mm h-210mm' : 'w-210mm h-297mm']"
  >
    <component
      :is="'style'"
      type="text/css"
      media="print"
    >
      @page { size: {{ landscape ? 'landscape' : 'portrait' }}; }
    </component>

    <Suspense>
      <RouterView />

      <template #fallback>
        <div class="grow w-full min-h-30vh flex justify-center items-center">
          <q-circular-progress
            indeterminate
            size="lg"
            color="primary"
          />
        </div>
      </template>
    </Suspense>
  </div>
</template>
