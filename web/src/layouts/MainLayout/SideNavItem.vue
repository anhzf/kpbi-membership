<template>
  <q-item
    v-ripple
    clickable
  >
    <q-item-section
      v-if="icon"
      avatar
    >
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ title }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script lang="ts" setup>
interface Props {
  title: string;
  icon?: string;
}

defineProps<Props>();
</script>
