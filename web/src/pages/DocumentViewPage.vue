<script lang="ts" setup>
import { DOCUMENT_TEMPLATES } from 'src/document/templates';

const template = DOCUMENT_TEMPLATES['bukti-keanggotaan'];
const size = template.root.size || 'A4 portrait';
</script>

<template>
  <main class="root w-297mm h-210mm">
    <component
      :is="template.component"
      :data="{
        number: '055/02/KPBI/2024',
        name: 'Prodi S1 Pendidikan Biologi, FKIP, Universitas Kapuas Sintang',
        period: [new Date('2024-01-01'), new Date('2025-12-31')],
        date: new Date(),
      }"
    />
  </main>
</template>

<!-- <style lang="scss" scoped>
.root {
  size: v-bind(size);
}
</style> -->

<!-- <style lang="scss">
@media print {
  @page {
    size: v-bind(size);
  }
}
</style> -->
