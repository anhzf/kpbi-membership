<template>
  <q-item
    clickable
    :to="to"
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

<script lang="ts">
import { defineComponent } from 'vue';
import type { PropType } from 'vue';
import type { RouteLocationRaw } from 'vue-router';

export default defineComponent({
  name: 'SideNavbarItem',
  props: {
    title: {
      type: String,
      required: true,
    },
    icon: {
      type: String,
      default: '',
    },
    to: {
      type: [String, Object] as PropType<RouteLocationRaw>,
      default: '#',
    },
  },
});
</script>
