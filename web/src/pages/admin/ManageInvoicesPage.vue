<script lang="ts" setup>
import { useQuery } from '@tanstack/vue-query';
import { formatDistanceToNow } from 'date-fns';
import { id as idLocale } from 'date-fns/locale';
import { title } from 'node:process';
import { type QTableProps, useQuasar } from 'quasar';
import { documentGet, documentList, documentUpdate } from 'src/services/document';
import type { DocumentListItem } from 'src/types/models';
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

const PAGINATION = ref<NonNullable<QTableProps['pagination']>>({
  sortBy: 'created_at',
  descending: true,
  rowsPerPage: 15,
});

const $q = useQuasar();

const { data, isFetching: isLoading, refetch: refresh } = useQuery({
  queryKey: [
    'admin',
    'documents',
    DOCUMENT_TYPE,
    computed(() => [PAGINATION.value.page, PAGINATION.value.rowsPerPage, PAGINATION.value.sortBy, PAGINATION.value.descending ? 'desc' : 'asc'].join('-')),
  ],
  queryFn: () => documentList(DOCUMENT_TYPE) as Promise<InvoiceDocumentListItem[]>,
  initialData: [],
  refetchOnWindowFocus: false,
  refetchOnReconnect: false,
  refetchOnMount: true,
});

const rows = computed(() => data.value || []);

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
</script>

<template>
  <q-page
    padding
    class="column q-gutter-md"
  >
    <q-table
      v-model:pagination="PAGINATION"
      title="Kelola Invoice"
      :columns="COLUMNS"
      :rows
      :loading="isLoading"
      row-key="id"
    >
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
