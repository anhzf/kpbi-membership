<script lang="ts" setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';

// import { DOCUMENT_TEMPLATES } from 'src/document/templates';
// import { documentGet } from 'src/services/document';
// import type { Component } from 'vue';
// import { useRoute } from 'vue-router';

const route = useRoute();
const landscape = computed(() => route.meta.landscape);

// const route = useRoute();

// const doc = await documentGet(route.params.documentId as string);

// const template = DOCUMENT_TEMPLATES[doc.template as keyof typeof DOCUMENT_TEMPLATES];
// const size = template.root.size || 'A4 landscape';
</script>

<template>
  <div :class="['root p-1', landscape ? 'w-297mm h-210mm' : 'w-210mm h-297mm']">
    <Suspense>
      <RouterView />
    </Suspense>
    <!-- <component
      :is="(template.component as Component)"
      v-bind="doc.payload"
    /> -->
  </div>
</template>

<style lang="scss">
// @page {
//   size: v-bind(size);
//   margin: 0.2in 0.15in;
// }
</style>
