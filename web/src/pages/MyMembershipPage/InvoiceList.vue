<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import { invoiceList } from 'src/services/invoice';

const { state: list, execute: refresh, isLoading: listLoading } = useAsyncState(invoiceList, []);
</script>

<template>
  <q-card>
    <q-card-section>
      <h6 class="my-0">
        Riwayat
      </h6>

      <q-markup-table
        flat
        class="h-50vh"
      >
        <thead>
          <tr>
            <th class="text-left">
              Tanggal
            </th>
            <th>Status</th>
            <th />
          </tr>
        </thead>

        <tbody>
          <template v-if="list.length">
            <tr
              v-for="invoice in list"
              :key="invoice.id"
            >
              <td>
                {{
                  invoice.created_at.toLocaleString('id', { dateStyle: 'short', timeStyle: 'short' })
                }}
              </td>
              <td>
                {{ invoice.paid_at ? 'Lunas' : 'Belum Lunas' }}
              </td>
              <td class="text-right">
                <div class="inline-flex gap-2">
                  <q-btn
                    label="Tagihan"
                    icon="open_in_new"
                    :to="{ name: 'DocumentInvoice', params: { invoiceId: invoice.id }, query: { receipt: false } }"
                    target="_blank"
                    flat
                    dense
                  />
                  <q-btn
                    label="Kwitansi"
                    icon="open_in_new"
                    :to="{ name: 'DocumentInvoice', params: { invoiceId: invoice.id } }"
                    target="_blank"
                    flat
                    dense
                  />
                </div>
              </td>
            </tr>
          </template>

          <tr v-else>
            <td
              colspan="3"
              class="text-center"
            >
              Tidak ada riwayat tagihan
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-card-section>

    <q-inner-loading :showing="listLoading" />
  </q-card>
</template>
