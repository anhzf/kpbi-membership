<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import { QTableProps } from 'quasar';
import memberService, { GetMemberListQuery } from 'src/services/member';
import { ACADEMIC_DEGREES_LABELS } from 'src/types/constants';
import { MemberInList } from 'src/types/models';
import { q } from 'src/types/q';
import { watch } from 'vue';

interface Props {
  query?: GetMemberListQuery;
}

const props = defineProps<Props>();

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

const { state: data, isLoading, execute } = useAsyncState(() => memberService.list(props.query), []);

defineExpose({
  refresh: execute,
});

const pagination = {
  rowsPerPage: 10,
} as QTableProps['pagination'];

watch(props.query!, () => {
  execute();
});
</script>

<template>
  <q-table
    :columns="cols"
    :rows="data"
    row-key="action"
    :pagination="pagination"
    :loading="isLoading"
  >
    <template #body-cell-numb="scopedProps">
      <q-th
        :props="scopedProps"
        auto-width
      >
        {{ scopedProps.rowIndex + 1 }}
      </q-th>
    </template>

    <template #body-cell-webProdi="scopedProps">
      <q-td :props="scopedProps">
        <template v-if="scopedProps.value">
          <a
            :href="scopedProps.value"
            target="_blank"
          >
            {{ scopedProps.value }}
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

    <template #body-cell-action="scopedProps">
      <q-td :props="scopedProps">
        <slot
          name="action"
          :data="scopedProps"
        >
          {{ scopedProps.value }}
        </slot>
      </q-td>
    </template>
  </q-table>
</template>
