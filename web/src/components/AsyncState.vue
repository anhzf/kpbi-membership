<script lang="ts" setup generic="T">
import { useAsyncState, whenever } from '@vueuse/core';

interface Props {
  value: Promise<T>;
  init: T;
}

const props = defineProps<Props>();

const {
  state, isLoading, execute, error,
} = useAsyncState<T>(() => props.value, props.init);

whenever(() => props.value, () => execute());
</script>

<template>
  <slot
    :state="state"
    :is-loading="isLoading"
    :execute="execute"
    :error="error"
  />
</template>
