<script lang="ts" setup>
import { keepPreviousData, useQuery, useQueryClient } from '@tanstack/vue-query';
import { formatDistanceToNow } from 'date-fns';
import { id as idLocale } from 'date-fns/locale';
import { type QTableProps, useQuasar } from 'quasar';
import { documentGet, documentList, documentUpdate } from 'src/services/document';
import type { DocumentListItem, PaginatedList } from 'src/types/models';
import type { q } from 'src/types/q';
import { computed, ref } from 'vue';

interface InvoiceDocumentListItem extends DocumentListItem {
  invoice_number: string;
  member_name: string;
}

const DOCUMENT_TYPE = 'invoice';
const COLUMNS = <q.Table.ColumnDefinition<InvoiceDocumentListItem>[]>[
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
    label: 'ID',
    name: 'id',
    required: true,
    align: 'left',
    field: (row) => row.id,
    sortable: true,
    headerClasses: 'q-table--col-auto-width',
  },
  {
    label: 'Nomor Invoice',
    name: 'invoice_number',
    align: 'left',
    required: true,
    field: (row) => row.invoice_number,
    sortable: true,
  },
  {
    label: 'Nama Anggota',
    name: 'member_name',
    align: 'left',
    required: true,
    field: (row) => row.member_name,
    sortable: true,
  },
  {
    label: 'Dibuat',
    name: 'created_at',
    align: 'left',
    required: true,
    field: (row) => row.created_at,
    sortable: true,
    format: (val) => {
      const date = new Date(val);
      const diffInDays = (Date.now() - date.getTime()) / (1000 * 60 * 60 * 24);
      return diffInDays < 7
        ? formatDistanceToNow(date, { addSuffix: true, locale: idLocale })
        : date.toLocaleDateString('id-ID');
    },
  },
  {
    label: 'Diperbarui',
    name: 'updated_at',
    align: 'left',
    required: true,
    field: (row) => row.updated_at,
    sortable: true,
    format: (val) => {
      const date = new Date(val);
      const diffInDays = (Date.now() - date.getTime()) / (1000 * 60 * 60 * 24);
      return diffInDays < 7
        ? formatDistanceToNow(date, { addSuffix: true, locale: idLocale })
        : date.toLocaleDateString('id-ID');
    },
  },
  {
    label: 'Aksi',
    name: 'actions',
    align: 'left',
    required: true,
    field: (row) => row.id,
    sortable: false,
  },
];

const $q = useQuasar();
const queryClient = useQueryClient();

const filter = ref('');
const pagination = ref<QTableProps['pagination']>({
  sortBy: 'created_at',
  descending: true,
  page: 1,
  rowsPerPage: 15,
});

const paginationKey = [
  'admin',
  'documents',
  DOCUMENT_TYPE,
  computed(() => [
    pagination.value?.page,
    pagination.value?.rowsPerPage,
    pagination.value?.sortBy,
    pagination.value?.descending ? 'desc' : 'asc',
    filter.value,
  ].join('-'))
] as const;

const { data: pageable, isFetching: isLoading } = useQuery({
  queryKey: paginationKey,
  queryFn: async () => {
    const result = await documentList(DOCUMENT_TYPE, {
      search: filter.value,
      per_page: pagination.value?.rowsPerPage,
      page: pagination.value?.page,
    }) as PaginatedList<InvoiceDocumentListItem>;

    pagination.value = {
      ...pagination.value,
      page: result.current_page,
      rowsPerPage: result.per_page,
      rowsNumber: result.total,
    };

    return result;
  },
  initialData: null,
  placeholderData: keepPreviousData,
  refetchOnWindowFocus: false,
  refetchOnReconnect: false,
  refetchOnMount: true,
});
const refresh = () => queryClient.invalidateQueries({ queryKey: paginationKey });

const rows = computed(() => pageable.value?.data || []);

const onEditClick = async (id: string) => {
  const dialog = $q.dialog({
    title: 'Edit Invoice',
    progress: true,
    persistent: true,
    class: 'w-full max-w-screen-lg',
    ok: {
      label: 'Simpan',
      color: 'primary',
      disabled: true,
    },
  });

  const doc = await documentGet(id);

  dialog.update({
    progress: false,
    persistent: false,
    prompt: {
      model: JSON.stringify(doc.payload, null, 2),
      type: 'textarea',
      filled: true,
      inputClass: 'h-64',
    },
    ok: {
      disabled: false,
    }
  });

  dialog.onOk(async (payload: string) => {
    try {
      $q.loading.show({
        message: 'Menyimpan perubahan...',
      });

      const parsed = JSON.parse(payload);
      await documentUpdate(doc.id, parsed);

      refresh();
      $q.notify({
        type: 'positive',
        message: 'Invoice berhasil diperbarui.',
      });
    } catch (error) {
      console.error('Error updating document:', error);
      $q.notify({
        type: 'negative',
        message: 'Gagal memperbarui invoice. Silakan coba lagi.',
      });
    } finally {
      $q.loading.hide();
    }
  });
};

const onTableRequest: QTableProps['onRequest'] = (props) => {
  pagination.value = props.pagination;
};
</script>

<template>
  <q-page
    padding
    class="column q-gutter-md"
  >
    <q-table
      v-model:pagination="pagination"
      title="Kelola Invoice"
      :columns="COLUMNS"
      :rows
      :loading="isLoading"
      row-key="id"
      :rows-per-page-options="[5, 7, 10, 15, 20, 25, 50]"
      @request="onTableRequest"
    >
      <template #top-right>
        <q-input
          v-model.lazy="filter"
          outlined
          placeholder="Cari invoice..."
          dense
        >
          <template #append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template #body-cell-numb="scopedProps">
        <q-td :props="scopedProps">
          {{ scopedProps.rowIndex + 1 }}
        </q-td>
      </template>

      <template #body-cell-actions="scopedProps">
        <q-td :props="scopedProps">
          <div class="row items-center q-gutter-sm">
            <q-btn
              label="Lihat"
              color="primary"
              flat
              dense
              :to="{ name: 'Document', params: { documentId: scopedProps.row.id } }"
              target="_blank"
            />
            <q-btn
              label="Edit"
              color="primary"
              flat
              dense
              @click="onEditClick(scopedProps.row.id)"
            />
          </div>
        </q-td>
      </template>
    </q-table>
  </q-page>
</template>
