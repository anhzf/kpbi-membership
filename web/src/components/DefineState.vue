<script lang="ts" setup generic="T">
interface Props {
  value: T
}

defineProps<Props>();
</script>

<template>
  <slot :state="value" />
</template>
