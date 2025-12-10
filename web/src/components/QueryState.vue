<script lang="ts" setup generic="T">
import { useQuery } from '@tanstack/vue-query';
import { reactive } from 'vue';

export interface QueryStateProps<T> {
  queryKey: string[];
  queryFn: () => Promise<T>;
}

const props = defineProps<QueryStateProps<T>>();
const queryReturns = reactive(useQuery({
  queryKey: props.queryKey,
  queryFn: props.queryFn,
}));
</script>

<template>
  <slot v-bind="queryReturns" />
</template>
