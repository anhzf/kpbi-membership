<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import axios from 'axios';
import { Dialog, Notify } from 'quasar';
import { useLoading } from 'src/composables/use-loading';
import memberService, { isMemberVerified } from 'src/services/member';
import type { MembershipRequestStatus } from 'src/types/constants';
import { getErrMsg } from 'src/utils/simpler';
import { computed } from 'vue';

const CONFIRMATION_NUMBER = '6287838692859';
const CONFIRMATION_WORD = (program: string, college: string) => `Mohon diverifikasi keanggotaan Prodi ${program} Perguruan Tinggi ${college} pada Sistem Keanggotaan KPBI.`;

const REQUEST_STATUS_LABELS: Record<MembershipRequestStatus, string> = {
  pending: 'Menunggu',
  approved: 'Disetujui',
  rejected: 'Ditolak',
};

const REQUEST_STATUS_COLORS: Record<MembershipRequestStatus, string> = {
  pending: 'blue-grey',
  approved: 'positive',
  rejected: 'negative',
};

const REQUEST_STATUS_TEXT_COLORS: Record<MembershipRequestStatus, string> = {
  pending: 'white',
  approved: 'white',
  rejected: 'white',
};

const [isLoading, loading] = useLoading();

const { state: membership, isLoading: isMembershipLoading } = useAsyncState(() => memberService.get('me'), null);
const { state: listRequest, execute: refresh, isLoading: listRequestLoading } = useAsyncState(memberService.listRequest, []);

const isVerified = computed(() => !!membership.value && isMemberVerified(membership.value));

const onFileChange = (ev: Event) => {
  const target = ev.target as HTMLInputElement;
  const file = target.files?.[0];
  if (!file) return;

  Dialog.create({
    title: 'Konfirmasi Unggah Bukti Pembayaran',
    message: `Anda akan mengunggah "${file.name}" sebagai bukti pembayaran.`,
    ok: {
      label: 'Kirim',
    },
    cancel: true,
    prompt: {
      model: '',
      type: 'datetime-local',
      label: 'Tanggal transfer',
      hint: 'Masukkan tanggal transfer',
      required: true,
    },
  })
    .onOk(async (transferAt) => {
      try {
        await loading(memberService.request(file, new Date(transferAt)));
        refresh();
        Dialog.create({
          message: 'Untuk pelayanan lebih cepat, Mohon konfirmasi pembayaran ke Admin melalui WhatsApp. Terima kasih.',
          ok: {
            label: 'Hubungi Admin',
            // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
            href: `https://wa.me/${CONFIRMATION_NUMBER}?text=${encodeURIComponent(CONFIRMATION_WORD(membership.value!.education_program.name, membership.value!.college.name))}`,
            target: '_blank',
          },
        });
      } catch (err) {
        Notify.create({ type: 'negative', message: getErrMsg(err) });
        if (!(axios.isAxiosError(err) && err.response?.status
          && (err.response.status >= 400 || err.response.status < 500))) {
          console.error(err);
        }
      } finally {
        target.value = '';
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
        :disable="isVerified"
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

      <div
        v-if="isVerified"
        class="absolute inset-0 bg-slate/20"
      />
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
              Tanggal Pengajuan
            </th>
            <th>
              Tanggal Transfer
            </th>
            <th>Status</th>
            <th />
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

              <td class="text-grey text-center w-8ch">
                {{ item.transfer_at?.toLocaleString('id', {dateStyle:'short',timeStyle: 'short'}) }}
              </td>

              <td>
                <div
                  class="flex flex-col items-center gap-1"
                  :class="{'justify-center': item.status === 'pending'}"
                >
                  <q-chip
                    :label="REQUEST_STATUS_LABELS[item.status]"
                    :color="REQUEST_STATUS_COLORS[item.status]"
                    :text-color="REQUEST_STATUS_TEXT_COLORS[item.status]"
                  />
                  <div
                    v-if="item.valid_until"
                    class="flex gap-1 text-positive"
                  >
                    <span>Diperpanjang sampai</span>
                    <time>{{ item.valid_until.toLocaleString('id', {dateStyle: 'short'}) }}</time>
                  </div>
                </div>
              </td>

              <td class="text-right">
                <div class="column items-end q-gutter-xs">
                  <!-- <q-btn
                    label="Tagihan"
                    icon="attachment"
                    :href="item.attachment_url"
                    target="_blank"
                    flat
                    dense
                  /> -->
                  <q-btn
                    label="Bukti Pembayaran"
                    icon="attachment"
                    :href="item.attachment_url"
                    target="_blank"
                    flat
                    dense
                    size="small"
                  />
                </div>
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

    <q-inner-loading :showing="isLoading || listRequestLoading || isMembershipLoading" />
  </q-card>
</template>
