<template>
  <q-table
    :columns="columnDefinitions"
    :rows="data"
    row-key="action"
    :pagination="pagination"
  >
    <template #body-cell-numb="props">
      <q-th
        :props="props"
        auto-width
      >
        {{ props.rowIndex }}
      </q-th>
    </template>

    <template #body-cell-webProdi="props">
      <q-td :props="props">
        <a
          :href="props.value"
          target="_blank"
        >
          {{ props.value }}
        </a>
        <q-icon
          name="open_in_new"
          color="blue-13"
          class="q-ml-xs"
        />
      </q-td>
    </template>

    <template #body-cell-action="props">
      <q-td :props="props">
        <slot
          name="action"
          :data="props"
        >
          {{ props.value }}
        </slot>
      </q-td>
    </template>
  </q-table>
</template>

<script lang="ts" setup>
import { defineProps, defineExpose } from 'vue';
import type { QTableProps } from 'quasar';
import type { q } from 'src/types/q';
import type { Member } from 'src/types/models';

defineProps<{
  data: Member[],
}>();

const columnDefinitions = [
  {
    label: '#',
    name: 'numb',
    required: true,
    align: 'left',
    field: (row) => row.id,
    sortable: false,
    classes: 'text-blue-grey-13',
    headerClasses: 'q-table--col-auto-width',
  },
  {
    label: 'JENJANG',
    name: 'jenjang',
    required: true,
    align: 'left',
    field: (row) => row.jenjang,
    sortable: true,
    headerClasses: 'q-table--col-auto-width',
  },
  {
    label: 'PRODI',
    name: 'namaProdi',
    align: 'left',
    required: true,
    field: (row) => row.namaProdi,
    sortable: true,
  },
  {
    label: 'PERGURUAN TINGGI',
    name: 'pt',
    align: 'left',
    required: true,
    field: (row) => row.namaPT,
    sortable: true,
  },
  {
    label: 'WEBSITE PRODI',
    name: 'webProdi',
    align: 'left',
    required: true,
    field: (row) => row.link,
    sortable: false,
  },
  {
    label: 'AKSI',
    name: 'action',
    align: 'right',
    required: true,
    field: (row) => row.id,
    sortable: false,
  },
] as q.Table.ColumnDefinition<Member>[] as q.Table.ColumnOrig[];

const pagination = {
  rowsPerPage: 10,
} as QTableProps['pagination'];

defineExpose({
  columnDefinitions,
  pagination,
});
</script>
