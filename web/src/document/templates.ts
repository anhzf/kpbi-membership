import { defineAsyncComponent, type Component } from 'vue';

interface DocumentTemplate {
  component: Component,
  landscape?: boolean,
}

export const documentTemplates: Record<string, DocumentTemplate> = {
  invoice: {
    component: defineAsyncComponent(() => import('./templates/BuktiPembayaran.vue')),
  },
  'membership-certificate': {
    component: defineAsyncComponent(() => import('./templates/BuktiKeanggotaan.vue')),
    landscape: true,
  },
};
