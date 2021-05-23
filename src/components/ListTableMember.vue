<template>
  <q-table
    :columns="columnDefinitions"
    :rows="numberedData"
    row-key="action"
    :pagination="pagination"
  >
    <template #header-cell-numb="props">
      <q-th
        :props="props"
        auto-width
      >
        {{ props.col.label }}
      </q-th>
    </template>

    <template #header-cell-jenjang="props">
      <q-th
        :props="props"
        auto-width
      >
        {{ props.col.label }}
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
  </q-table>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';
import type { q } from 'src/types';
import type { PropType } from 'vue';
import type { Member, Model, ModelInObject } from 'app/common/schema';

const columnDefinitions = [
  {
    label: '#',
    name: 'numb',
    required: true,
    align: 'left',
    field: (row) => row.numb,
    sortable: false,
    classes: 'text-blue-grey-13',
  },
  {
    label: 'JENJANG',
    name: 'jenjang',
    required: true,
    align: 'left',
    field: (row) => row.jenjang,
    sortable: true,
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
    field: (row) => row.perguruanTinggi.lengkap,
    sortable: true,
  },
  {
    label: 'WEBSITE PRODI',
    name: 'webProdi',
    align: 'left',
    required: true,
    field: (row) => row.webProdi,
    sortable: false,
  },
  {
    label: 'AKSI',
    name: 'action',
    align: 'right',
    required: true,
    field: (row) => row._uid,
    sortable: false,
  },
] as q.Table.ColumnDefinition<ModelInObject<Model<Member>> & {numb: number}>[];

const pagination = {
  rowsPerPage: 10,
} as q.Table['pagination'];

export default defineComponent({
  name: 'ListTableMember',
  props: {
    data: {
      type: Array as PropType<(ModelInObject<Model<Member>>)[]>,
      required: true,
    },
  },
  setup(props) {
    const numberedData = computed(() => props.data.map((el, numb) => Object.assign(el, { numb })));

    return {
      columnDefinitions,
      pagination,
      numberedData,
    };
  },
});
</script>
