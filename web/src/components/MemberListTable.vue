<template>
  <q-table
    :columns="cols"
    :rows="data"
    row-key="action"
    :pagination="pagination"
    :loading="isLoading"
  >
    <template #body-cell-numb="props">
      <q-th
        :props="props"
        auto-width
      >
        {{ props.rowIndex + 1 }}
      </q-th>
    </template>

    <template #body-cell-webProdi="props">
      <q-td :props="props">
        <template v-if="props.value">
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
        </template>
        <span v-else>-</span>
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
import { useAsyncState } from '@vueuse/core';
import { QTableProps } from 'quasar';
import memberService from 'src/services/member';
import { ACADEMIC_DEGREES_LABELS } from 'src/types/constants';
import { MemberInList } from 'src/types/models';
import { q } from 'src/types/q';

const cols = [
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
    field: (row) => ACADEMIC_DEGREES_LABELS[row.education_program.degree],
    sortable: true,
    headerClasses: 'q-table--col-auto-width',
  },
  {
    label: 'PRODI',
    name: 'namaProdi',
    align: 'left',
    required: true,
    field: (row) => row.education_program.name,
    sortable: true,
  },
  {
    label: 'PERGURUAN TINGGI',
    name: 'pt',
    align: 'left',
    required: true,
    field: (row) => row.education_program.college.name,
    sortable: true,
  },
  {
    label: 'WEBSITE PRODI',
    name: 'webProdi',
    align: 'left',
    required: true,
    field: (row) => row.education_program.external_link,
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
] as q.Table.ColumnDefinition<MemberInList>[];

const { state: data, isLoading, execute } = useAsyncState(memberService.list, []);

defineExpose({
  refresh: execute,
});

const pagination = {
  rowsPerPage: 10,
} as QTableProps['pagination'];
</script>
