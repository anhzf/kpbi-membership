<script lang="ts" setup generic="T">
import { Ref, ref } from 'vue';

interface Props {
  value: T;
}

const props = defineProps<Props>();

const state = ref(props.value) as Ref<T>;
const setState = (value: T) => {
  state.value = value;
};
</script>

<template>
  <slot
    :states="([state, setState] as const)"
    :bind-v-model="{modelValue: state, 'onUpdate:modelValue': setState}"
  />
</template>
