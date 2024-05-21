<script lang="ts" setup>
// import { DOCUMENT_TEMPLATES } from 'src/document/templates';
// import { documentGet } from 'src/services/document';
// import type { Component } from 'vue';
// import { useRoute } from 'vue-router';

// const route = useRoute();

// const doc = await documentGet(route.params.documentId as string);

// const template = DOCUMENT_TEMPLATES[doc.template as keyof typeof DOCUMENT_TEMPLATES];
// const size = template.root.size || 'A4 landscape';
</script>

<template>
  <main class="root w-297mm h-210mm p-1">
    <Suspense>
      <RouterView />

      <template #fallback="payload">
        Oops! Something went wrong.
        <pre>{{ payload }}</pre>
      </template>
    </Suspense>
    <!-- <component
      :is="(template.component as Component)"
      v-bind="doc.payload"
    /> -->
  </main>
</template>

<style lang="scss">
// @page {
//   size: v-bind(size);
//   margin: 0.2in 0.15in;
// }
</style>
