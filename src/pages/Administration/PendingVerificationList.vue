<template>
  <q-table
    :rows="data"
    :columns="columnDefinitions"
    :pagination="pagination"
    flat
    bordered
  >
    <template #body-cell-action="props">
      <q-td :props="props">
        <q-btn
          :label="props.row._uid"
          @click="openReviewDialog"
        />
      </q-td>
    </template>
  </q-table>
</template>

<script lang="ts">
import {
  defineComponent, reactive, toRefs,
} from 'vue';
import { Dialog } from 'quasar';
import ReviewDialog from 'pages/Administration/ReviewDialog.vue';
import { collections, factories } from 'src/firestoreServices';
import type { q } from 'src/types';
import type { Model, ModelInObject, RequestVerification } from 'app/common/schema';

type WantedModel = ModelInObject<Model<RequestVerification>> & {numb: number};

const columnDefinitions = [
  {
    label: '#',
    name: 'numb',
    required: true,
    align: 'left',
    field: (row) => row.numb.toString(),
    sortable: false,
    classes: 'text-blue-grey-13',
  },
  {
    label: 'USER',
    name: 'user',
    required: true,
    align: 'left',
    field: (row) => row.user.id,
    sortable: true,
  },
  {
    label: 'AKSI',
    name: 'action',
    align: 'right',
    required: true,
    field: (row) => row._uid,
    sortable: false,
  },
] as q.Table.ColumnDefinition<WantedModel>[];

const pagination = {
  rowsPerPage: 10,
} as q.Table['pagination'];

export default defineComponent({
  name: 'PendingVerificationList',
  setup() {
    const state = reactive({
      data: [
        {
          _uid: 'asd',
          numb: 0,
          documentPath: '',
          user: collections.Members.doc(),
          message: '',
          ...factories.attrs.create(),
        },
      ] as WantedModel[],
    });
    const openReviewDialog = () => Dialog.create({
      component: ReviewDialog,
    })
      .onOk(console.log);

    return {
      ...toRefs(state),
      columnDefinitions,
      pagination,
      openReviewDialog,
    };
  },
});
</script>
