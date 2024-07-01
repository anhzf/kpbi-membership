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
import { ref, watch } from 'vue';
import VerifyMembershipDialog from './VerifyMembershipDialog.vue';

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

const REQUEST_STATUS_OPTIONS = Object.entries(REQUEST_STATUS_LABELS).map(([value, label]) => ({
  value,
  label,
}));

/* TODO: Fix typings */
const getItemName = (item: MembershipRequest) => getMemberDisplayName({
  college: (item.membership.education_program as any).college,
  education_program: item.membership.education_program as any,
}, true);

const [isOverlayLoading, overlayLoading] = useLoading();

const filter = ref({
  status: 'pending' as MembershipRequestStatus,
});

const { state: list, execute: refresh, isLoading: listLoading } = useAsyncState(
  () => adminService.membershipRequestList(filter.value.status),
  [],
);

const onRejectClick = async (item: MembershipRequest) => {
  Dialog.create({
    message: 'Apakah Anda yakin ingin menolak ajuan ini?',
    ok: true,
    cancel: true,
    componentProps: {
      name: getItemName(item),
    },
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
    component: VerifyMembershipDialog,
    componentProps: {
      mode: item.valid_until ? 'edit' : 'accept',
      name: getItemName(item),
      value: {
        validStart: item.valid_start,
        validUntil: item.valid_until,
        /* TODO: Fix typings */
        registrationId: (item.membership as any).registration_id,
      },
    },
  })
    .onOk(async ({ validStart, validUntil, registrationId }) => {
      try {
        await overlayLoading(
          adminService.membershipRequestApprove(item.id, {
            validStart: new Date(validStart),
            validUntil: new Date(validUntil),
            registrationId,
          }),
        );
        refresh();
        Notify.create({ message: 'Ajuan berhasil disetujui', type: 'positive' });
      } catch (err) {
        Notify.create({ type: 'negative', message: getErrMsg(err) });
        if (!(axios.isAxiosError(err) && err.response?.status
          && (err.response.status >= 400 || err.response.status < 500))) {
          console.error(err);
        }
      }
    });
};

const onEditClick = onAcceptClick;

watch(() => filter.value.status, () => refresh());
</script>

<template>
  <q-card>
    <q-card-section>
      <div class="flex justify-between items-center">
        <h6 class="my-0">
          Verifikasi Pembayaran
        </h6>

        <q-select
          v-model="filter.status"
          label="Status"
          :options="REQUEST_STATUS_OPTIONS"
          rounded
          standout
          dense
          map-options
          emit-value
        />
      </div>

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
            <th class="text-right" />
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
              <td class="max-w-35ch truncate">
                <router-link
                  :to="{name: 'Member', params: {memberId: item.membership.id}}"
                  target="_blank"
                >
                  {{ getItemName(item) }}
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
                  <q-btn-group unelevated>
                    <q-btn
                      icon="attachment"
                      :href="item.attachment_url"
                      target="_blank"
                    />

                    <template v-if="item.status === 'pending'">
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
                    </template>

                    <template v-else-if="item.status === 'approved'">
                      <q-btn
                        icon="edit"
                        @click="onEditClick(item)"
                      />
                    </template>
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
