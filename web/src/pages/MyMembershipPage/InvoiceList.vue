<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import AsyncState from 'src/components/AsyncState.vue';
import { invoiceList } from 'src/services/invoice';
import { pdfGetUrl } from 'src/services/pdf';

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
                <AsyncState
                  :value="pdfGetUrl(`pembayaran/${invoice?.id}`, {format: 'A4', margin: 0, printBackground: true})"
                  init="#"
                  #="{state}"
                >
                  <q-btn
                    label="Lihat"
                    icon="open_in_new"
                    :href="state"
                    target="_blank"
                    flat
                    dense
                  />
                </AsyncState>
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
