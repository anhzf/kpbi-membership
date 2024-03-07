<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import axios from 'axios';
import { Dialog, Notify } from 'quasar';
import { useLoading } from 'src/composables/use-loading';
import adminService from 'src/services/admin';
import { getMemberDisplayName } from 'src/services/member';
import { MembershipRequestStatus } from 'src/types/constants';
import { MembershipRequest } from 'src/types/models';
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

const [isOverlayLoading, overlayLoading] = useLoading();

const { state: list, execute: refresh, isLoading: listLoading } = useAsyncState(adminService.membershipRequestList, []);

const onRejectClick = async (item: MembershipRequest) => {
  Dialog.create({
    message: 'Apakah Anda yakin ingin menolak ajuan ini?',
    ok: true,
    cancel: true,
  })
    .onOk(async () => {
      try {
        await overlayLoading(adminService.membershipRequestApprove(item.id));
        refresh();
        Notify.create('Ajuan berhasil ditolak');
      } catch (err) {
        Notify.create({ type: 'negative', message: getErrMsg(err) });
        if (!(axios.isAxiosError(err) && err.response?.status
          && (err.response.status >= 400 || err.response.status < 500))) {
          console.error(err);
        }
      }
    });
};

const onAcceptClick = async (item: MembershipRequest) => {
  Dialog.create({
    title: 'Terima Ajuan Keanggotaan',
    message: 'Mohon masukkan masa berlaku keanggotaan',
    prompt: {
      model: new Date(Date.now() + 3600_000 * 24 * 365).toISOString().slice(0, 10),
      type: 'date',
    },
    ok: true,
    cancel: true,
  })
    .onOk(async (validUntil) => {
      try {
        await overlayLoading(adminService.membershipRequestApprove(item.id, new Date(validUntil)));
        refresh();
        Notify.create('Ajuan berhasil disetujui');
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
  <q-card>
    <q-card-section>
      <h6 class="my-0">
        Verifikasi Pembayaran
      </h6>

      <q-markup-table
        flat
        class="h-60vh"
      >
        <thead>
          <tr>
            <th class="text-left">
              Tanggal
            </th>
            <th class="text-left">
              Keanggotaan
            </th>
            <th>Status</th>
            <th class="text-right">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-if="list.length">
            <tr
              v-for="item in list"
              :key="item.id"
            >
              <td class="text-grey text-left w-8ch">
                {{ item.requested_date.toLocaleString('id', {dateStyle:'short',timeStyle: 'short'}) }}
              </td>
              <td>
                <router-link
                  :to="{name: 'Member', params: {memberId: item.membership.id}}"
                  target="_blank"
                >
                  {{ getMemberDisplayName(item.membership as any, true) }}
                  <q-icon name="open_in_new" />
                </router-link>
              </td>
              <td class="text-center w-6ch">
                <q-chip
                  :label="REQUEST_STATUS_LABELS[item.status]"
                  :color="REQUEST_STATUS_COLORS[item.status]"
                />
              </td>
              <td>
                <div class="flex justify-end items-center gap-2">
                  <q-btn
                    icon="visibility"
                    :href="item.attachment_url"
                    target="_blank"
                    flat
                    round
                  />
                  <q-btn-group v-if="item.status === 'pending'">
                    <q-btn
                      icon="close"
                      color="negative"
                      @click="onRejectClick(item)"
                    />
                    <q-btn
                      icon="check"
                      color="positive"
                      @click="onAcceptClick(item)"
                    />
                  </q-btn-group>
                </div>
              </td>
            </tr>
          </template>

          <tr v-else>
            <td
              class="text-center"
              colspan="5"
            >
              Tidak ada ajuan riwayat bukti pembayaran
            </td>
          </tr>
        </tbody>
      </q-markup-table>
    </q-card-section>

    <q-inner-loading :showing="isOverlayLoading || listLoading" />
  </q-card>
</template>
