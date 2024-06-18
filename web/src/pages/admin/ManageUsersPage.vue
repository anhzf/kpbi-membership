<script lang="ts" setup>
import { useQuery } from '@tanstack/vue-query';
import { listUsers, setUserRole } from 'src/services/admin';
import { User } from 'src/types/models';
import type { q } from 'src/types/q';
import { Notify, type QTableProps } from 'quasar';
import { USER_ROLES, UserRole } from 'src/types/constants';
import { useLoading } from 'src/composables/use-loading';
import axios from 'axios';
import { getErrMsg } from 'src/utils/simpler';
import { ref } from 'vue';

const COLUMNS = <q.Table.ColumnDefinition<User>[]>[
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
    label: 'Nama',
    name: 'name',
    required: true,
    align: 'left',
    field: (row) => row.name,
    sortable: true,
    headerClasses: 'q-table--col-auto-width',
  },
  {
    label: 'Role',
    name: 'role',
    align: 'center',
    required: true,
    field: (row) => row.role,
    sortable: true,
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

const PAGINATION = <QTableProps['pagination']>{
  rowsPerPage: 15,
};

const [isOverlayLoading, overlayLoading] = useLoading();

const { data, isFetching: isLoading, refetch } = useQuery({
  queryKey: ['admin', 'users'],
  queryFn: listUsers,
  initialData: [],
});

const filter = ref('');

const onRoleSelect = async (row: User, role: string) => {
  try {
    await overlayLoading(setUserRole(row.id, role === 'default' ? undefined : role as UserRole));
    const userIdx = data.value.findIndex((user) => user.id === row.id);
    data.value[userIdx].role = role as UserRole;
    refetch();
    Notify.create({
      type: 'positive',
      message: 'Role pengguna berhasil diubah',
    });
  } catch (err) {
    Notify.create({ type: 'negative', message: getErrMsg(err) });
    if (!(axios.isAxiosError(err) && err.response?.status
          && (err.response.status >= 400 || err.response.status < 500))) {
      console.error(err);
    }
  }
};
</script>

<template>
  <q-page
    padding
    class="column q-gutter-md"
  >
    <q-table
      title="Kelola Pengguna"
      :columns="COLUMNS"
      :pagination="PAGINATION"
      :rows="data"
      :loading="isLoading"
      :filter="filter"
    >
      <template #top-right>
        <q-input
          v-model="filter"
          outlined
          placeholder="Cari pengguna"
          dense
        >
          <template #append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template #body-cell-role="scopedProps">
        <q-td :props="scopedProps">
          <q-btn-dropdown
            :label="scopedProps.value || 'default'"
            unelevated
          >
            <q-list>
              <q-item
                v-close-popup
                v-for="role in ['default', ...USER_ROLES]"
                :key="role"
                clickable
                :active="(scopedProps.value || 'default') === role"
                @click="onRoleSelect(scopedProps.row, role)"
              >
                <q-item-section avatar>
                  <q-icon
                    name="check"
                  />
                </q-item-section>
                <q-item-section>
                  <q-item-label>{{ role.toUpperCase() }}</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </q-td>
      </template>

      <template #body-cell-actions="scopedProps">
        <q-td :props="scopedProps">
          <!-- <q-btn
            label="Detail"
            color="secondary"
            flat
            :to="{ name: 'AdminUserDetail', params: { userId: scopedProps.row.id } }"
          /> -->
        </q-td>
      </template>
    </q-table>

    <q-inner-loading :showing="isOverlayLoading" />
  </q-page>
</template>
