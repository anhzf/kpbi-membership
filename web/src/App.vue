<script lang="ts" setup>
import { VueQueryDevtools } from '@tanstack/vue-query-devtools';
</script>

<template>
  <Suspense>
    <router-view />

    <template #fallback>
      <div class="grow w-full min-h-30vh flex justify-center items-center">
        <q-circular-progress
          indeterminate
          size="lg"
          color="primary"
        />
      </div>
    </template>
  </Suspense>
  <VueQueryDevtools />
</template>
