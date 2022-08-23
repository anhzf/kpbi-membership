<template>
  <q-page padding>
    <pre>{{ auth.user }}</pre>
  </q-page>
</template>

<script lang="ts" setup>
import { useAuthStore } from 'src/stores/auth';

const auth = useAuthStore();
</script>
