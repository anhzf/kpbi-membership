<script lang="ts" setup>
import { useQuery } from '@tanstack/vue-query';
import { until } from '@vueuse/core';
import { Dialog, Loading, Notify } from 'quasar';
import QueryState from 'src/components/QueryState.vue';
import { listUsers } from 'src/services/admin';
import { systemApi } from 'src/services/v2/system';
import { getErrMsg } from 'src/utils/simpler';
import { computed, ref } from 'vue';

interface PropertyDefinition<T> {
  label: string;
  getData: () => Promise<T>;
  format?: (value: T) => string;
  onEditClick?: (key: string, currentValue: T) => Promise<void>;
}

interface PersonSelector {
  title: string;
  selectedId: number | null;
  _wantsClose?: true;
  _isLoading?: boolean;
}

const defineProperty = <T>(def: PropertyDefinition<T>) => def;

const {
  data: persons, isFetching: isPersonsLoading, refetch: refetchPersons, isFetched: isPersonsFetched,
} = useQuery({
  queryKey: ['admin', 'users'],
  queryFn: listUsers,
  initialData: [],
  refetchOnMount: false,
  refetchOnWindowFocus: false,
  refetchOnReconnect: false,
});

const personPicker = ref<PersonSelector>();
const selectionOfPerson = computed(() => {
  return personPicker.value
    ? persons.value.find((p) => p.id === String(personPicker.value?.selectedId)) || null
    : null;
});

// const personRows = computed(() => persons.value
//   // move the selected person to the top
//   .splice(
//     persons.value.findIndex((p) => p.id === String(personPicker.value?.selectedId)),
//     1,
//   )
//   .unshift(
//     persons.value.find((p) => p.id === String(personPicker.value?.selectedId))!,
//   ));

const openPeopleSelector = async (title: string, value?: number) => {
  if (!isPersonsFetched.value) {
    refetchPersons();
  }

  personPicker.value = {
    title: title,
    selectedId: value || null,
  };

  await until(personPicker.value)
    .toMatch((v) => v._wantsClose === true);

  return {
    value: personPicker.value
      ? personPicker.value.selectedId
      : null,
    close: () => {
      personPicker.value = undefined;
    },
  };
};

const properties: Record<string, PropertyDefinition<any>> = {
  membershipFee: defineProperty({
    label: 'Membership Fee',
    getData: systemApi.getMembershipFee,
    format: (value: number) => value
      .toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }),
    onEditClick: (key, currentValue) => new Promise((resolve) => {
      Dialog.create({
        title: 'Edit Membership Fee',
        prompt: {
          model: String(currentValue),
          type: 'number',
        },
        ok: 'Simpan',
        cancel: 'Batal',
      })
        .onOk(async (newValue: number) => {
          Loading.show();
          try {
            await systemApi.setMembershipFee(newValue);
            resolve();
          } catch (err) {
            Notify.create({
              type: 'negative',
              message: `Gagal memperbarui Membership Fee: ${getErrMsg(err)}`,
            });
          } finally {
            Loading.hide();
          }
        });
    })
  }),

  invoiceDocContactPerson: defineProperty({
    label: 'Invoice Contact Person',
    getData: systemApi.getInvoiceDocContactPerson,
    format: (value) => value.name,
    onEditClick: async (key, currentValue) => {
      const selector = await openPeopleSelector('Pilih Invoice Contact Person', currentValue?.id);
      personPicker.value!._isLoading = true;
      await systemApi.setInvoiceDocContactPerson(selector.value);
      selector.close();
    },
  }),

  invoiceDocTreasurer: defineProperty({
    label: 'Invoice Treasurer',
    getData: systemApi.getInvoiceDocTreasurer,
    format: (value) => value.name,
    onEditClick: async (key, currentValue) => {
      const selector = await openPeopleSelector('Pilih Invoice Treasurer', currentValue?.id);
      personPicker.value!._isLoading = true;
      await systemApi.setInvoiceDocTreasurer(selector.value);
      selector.close();
    },
  }),
};

const onPersonPickerClosed = () => {
  if (personPicker.value) {
    personPicker.value._wantsClose = true;
  }
};
</script>

<template>
  <q-page
    padding
    class="column items-center q-gutter-md"
  >
    <q-card class="w-full max-w-screen-sm">
      <q-card-section>
        <div class="text-h6">Pengaturan Sistem</div>
        <div class="text-subtitle2 text-grey-7">
          Klik untuk mengubah properti sistem.
        </div>
      </q-card-section>

      <q-separator />

      <q-list padding>
        <template
          v-for="(property, key) in properties"
          :key
        >
          <QueryState
            :query-key="['system', key]"
            :query-fn="property.getData"
            #="{ data, isFetching, refetch }"
          >
            <q-item
              @click="property.onEditClick?.(key, data)
                .then(() => refetch())
                .catch((err) => Notify.create({
                  type: 'negative',
                  message: 'Gagal memperbarui properti sistem: ' + getErrMsg(err),
                }))"
              :clickable="!!property.onEditClick && !isFetching"
            >
              <q-item-section>
                <q-item-label>
                  {{ property.label }}
                </q-item-label>
                <q-item-label caption>
                  <q-skeleton
                    v-if="isFetching"
                    type="text"
                    width="100px"
                  />
                  <template v-else>
                    {{ property.format ? property.format(data) : data }}
                  </template>
                </q-item-label>
              </q-item-section>
            </q-item>
          </QueryState>
        </template>
      </q-list>
    </q-card>

    <q-dialog
      :model-value="!!personPicker"
      @update:model-value="personPicker = undefined"
    >
      <q-card>
        <q-card-section>
          <div class="text-h6">
            {{ personPicker?.title }}
          </div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-table
            :rows="persons"
            :columns="[{
              name: 'title',
              label: 'Nama',
              field: 'name',
              sortable: true,
              align: 'left',
            }]"
            hide-header
            :selected="[selectionOfPerson]"
            row-key="id"
            selection="single"
            hide-selected-banner
            :loading="isPersonsLoading"
            flat
            @update:selected="([val]) => {
              personPicker!.selectedId = val.id;
            }"
            @row-click="(_, row) => {
              personPicker!.selectedId = Number(row.id);
            }"
          >
            <template #body-cell-title="props">
              <q-td :props="props">
                {{ props.row.name }}
                <div class="text-caption text-grey-7">
                  NIP {{ props.row.employee_id ?? '-' }}
                </div>
              </q-td>
            </template>
          </q-table>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn
            v-if="!personPicker?._isLoading"
            v-close-popup
            flat
            label="Close"
            color="primary"
          />
          <q-btn
            label="Pilih"
            color="primary"
            :loading="personPicker?._isLoading"
            @click="onPersonPickerClosed"
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>
