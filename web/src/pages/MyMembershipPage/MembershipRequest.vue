<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import axios from 'axios';
import { Dialog, Notify } from 'quasar';
import { useLoading } from 'src/composables/use-loading';
import memberService from 'src/services/member';
import type { MembershipRequestStatus } from 'src/types/constants';
import { getErrMsg } from 'src/utils/simpler';

const REQUEST_STATUS_LABELS: Record<MembershipRequestStatus, string> = {
  pending: 'Menunggu',
  approved: 'Disetujui',
  rejected: 'Ditolak',
};

const REQUEST_STATUS_COLORS: Record<MembershipRequestStatus, string> = {
  pending: 'grey-4',
  approved: 'positive',
  rejected: 'negative',
};

const REQUEST_STATUS_TEXT_COLORS: {[k in MembershipRequestStatus]?: string} = {
  approved: 'white',
  rejected: 'white',
};

const [isLoading, loading] = useLoading();

const { state: listRequest, execute: refresh, isLoading: listRequestLoading } = useAsyncState(memberService.listRequest, []);

const onFileChange = (ev: Event) => {
  const target = ev.target as HTMLInputElement;
  const file = target.files?.[0];
  if (!file) return;

  Dialog.create({ message: `Apakah Anda yakin ingin mengunggah "${file.name}" sebagai bukti pembayaran?`, ok: true, cancel: true })
    .onOk(async () => {
      try {
        await loading(memberService.request(file));
        refresh();
      } catch (err) {
        Notify.create({ type: 'negative', message: getErrMsg(err) });
        if (!(axios.isAxiosError(err) && err.response?.status
          && (err.response.status >= 400 || err.response.status < 500))) {
          console.error(err);
        }
      }
    });
};
</script>

<template>
  <q-card flat>
    <q-card-section class="h-40 flex flex-col justify-center items-center !border !border-dashed !border-slate !rounded">
      <q-btn
        label="Unggah bukti pembayaran"
        icon="upload"
      >
        <label class="absolute inset-0 cursor-pointer">
          <input
            type="file"
            class="invisible"
            accept="image/*,application/pdf"
            @change="onFileChange"
          >
        </label>
      </q-btn>
    </q-card-section>

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
            <th>Nama berkas</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="listRequest.length">
            <tr
              v-for="item in listRequest"
              :key="item.id"
            >
              <td class="text-grey text-left w-8ch">
                {{ item.requested_date.toLocaleString('id', {dateStyle:'short',timeStyle: 'short'}) }}
              </td>
              <td>
                <a
                  :href="item.attachment_url"
                  target="_blank"
                >
                  {{ item.created_at.getTime() }}.pdf
                  <q-icon name="open_in_new" />
                </a>
              </td>
              <td class="text-center w-6ch">
                <q-chip
                  :label="REQUEST_STATUS_LABELS[item.status]"
                  :color="REQUEST_STATUS_COLORS[item.status]"
                  :text-color="REQUEST_STATUS_TEXT_COLORS[item.status]"
                />
              </td>
            </tr>
          </template>

          <tr v-else>
            <td
              class="text-center"
              colspan="3"
            >
              Tidak ada riwayat bukti pembayaran
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-card-section>

    <q-inner-loading :showing="isLoading || listRequestLoading" />
  </q-card>
</template>
