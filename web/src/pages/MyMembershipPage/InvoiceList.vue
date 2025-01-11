<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import AsyncState from 'src/components/AsyncState.vue';
import DefineState from 'src/components/DefineState.vue';
import { invoiceList } from 'src/services/invoice';
import { pdfGetUrl } from 'src/services/pdf';
import { getErrMsg } from 'src/utils/simpler';

const { state: list, execute: refresh, isLoading: listLoading } = useAsyncState(invoiceList, []);

const getInvoiceUrl = async (id: string): Promise<string> => {
  const url = await pdfGetUrl(`pembayaran/${id}`, { format: 'A4', margin: 0, printBackground: true });
  window.open(url, '_blank');
  return url;
};
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
                <DefineState
                  value
                  #="{state: [isClicked, setIsClicked]}"
                >
                  <AsyncState
                    v-if="isClicked"
                    :value="getInvoiceUrl(invoice?.id)"
                    init="#"
                    #="{state,isLoading,error}"
                    @error="$q.notify({
                      type: 'negative',
                      message: `Gagal mendapatkan invoice: ${getErrMsg($event)}`
                    })"
                  >
                    <q-btn
                      label="Lihat"
                      icon="open_in_new"
                      :href="state"
                      target="_blank"
                      flat
                      dense
                      :loading="isLoading"
                      :disabled="error"
                    >
                      <q-badge
                        v-if="error"
                        color="red"
                        rounded
                        floating
                        title="Terjadi kesalahan dalam mendapatkan invoice"
                      >
                        !
                      </q-badge>
                    </q-btn>
                  </AsyncState>

                  <q-btn
                    v-else
                    label="Lihat"
                    icon="open_in_new"
                    flat
                    dense
                    @click.once="setIsClicked(true)"
                  />
                </DefineState>
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
