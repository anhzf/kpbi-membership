<template>
  <q-page class="row items-center justify-evenly">
    <pre>{{ state }}</pre>
    <ul>
      <li
        v-for="el in items"
        :key="el"
      >
        <router-link :to="{name: 'Member', params: {memberId: el}}">
          {{ el }}
        </router-link>
      </li>
    </ul>
  </q-page>
</template>

<script setup lang="ts">
import { useAsyncState } from '@vueuse/core';
import { nanoid } from 'nanoid';
import { api } from 'src/boot/axios';
import { ref } from 'vue';

const get = async () => {
  const { data } = await api('');
  return data;
};
const { state } = useAsyncState(get(), null);
const items = ref(Array.from({ length: 10 }, nanoid));
</script>
