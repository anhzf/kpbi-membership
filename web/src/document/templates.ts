import { defineAsyncComponent } from 'vue';

export const DOCUMENT_TEMPLATES = {
  'bukti-keanggotaan': {
    component: defineAsyncComponent(() => import('./templates/BuktiKeanggotaan.vue')),
    root: {
      size: 'A4 landscape',
    },
  },
};
