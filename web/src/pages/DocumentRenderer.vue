<script lang="ts" setup>
import { documentTemplates } from 'src/document/templates';
import { documentGet } from 'src/services/document';
import {
  onBeforeMount,
  onErrorCaptured,
  ref
} from 'vue';
import { useRoute } from 'vue-router';
import { useVueToPrint } from 'vue-to-print';

const route = useRoute();
const document = await documentGet(route.params.documentId as string);
if (!document) throw new Error('Document not found');

const template = documentTemplates[document.template_name];
if (!template) throw new Error('Document template not found');

const componentRef = ref();
const { handlePrint } = useVueToPrint({
  content: componentRef,
});

onBeforeMount(() => {
  window.readyToPrint ??= import.meta.env.DEV ? () => { /*  */ } : handlePrint;
});

onErrorCaptured((error) => {
  console.error(error);
  window.alert(error);
});
</script>

<template>
  <div
    ref="componentRef"
    :class="['root p-1', template.landscape ? 'w-297mm h-210mm' : 'w-210mm h-297mm']"
  >
    <component
      :is="'style'"
      type="text/css"
      media="print"
    >
      @page { size: {{ template.landscape ? 'landscape' : 'portrait' }}; }
    </component>

    <Suspense>
      <component
        :is="template.component"
        :payload="document.payload"
      />

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
