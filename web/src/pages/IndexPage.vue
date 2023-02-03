<template>
  <q-page
    padding
    class="column q-gutter-md"
  >
    <div class="row items-center gap-x-2">
      <div class="col-grow">
        <q-input
          v-model="search"
          label="Cari disini..."
          dense
          outlined
        >
          <template #append>
            <q-icon name="search" />
          </template>
        </q-input>
      </div>

      <div class="col-shrink">
        <q-btn
          label="refresh"
          icon="refresh"
          outline
          @click="onRefreshClick"
        />
      </div>
    </div>

    <member-list-table
      ref="refTable"
      :filter="search"
      class="max-h-full"
    >
      <template #action="{ data }">
        <q-btn
          label="Detail"
          color="secondary"
          flat
          :to="{name: 'Member', params: {memberId: data.value}}"
        />
      </template>
    </member-list-table>
  </q-page>
</template>

<script lang="ts" setup>
import MemberListTable from 'src/components/MemberListTable.vue';
import { ref } from 'vue';

const search = ref('');
const refTable = ref<typeof MemberListTable>();

const onRefreshClick = () => {
  refTable.value?.refresh();
};
</script>
