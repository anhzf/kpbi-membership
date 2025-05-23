<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import axios from 'axios';
import { addYears, endOfYear } from 'date-fns';
import { Dialog, Notify } from 'quasar';
import PatchInvoiceDialog from 'src/components/PatchInvoiceDialog.vue';
import { useLoading } from 'src/composables/use-loading';
import { MEMBERSHIP_FEE } from 'src/constants';
import { useAdminMembershipRequestsStates } from 'src/queries/admin';
import adminService from 'src/services/admin';
import { getMemberDisplayName } from 'src/services/member';
import { MembershipRequestStatus } from 'src/types/constants';
import { MembershipRequest } from 'src/types/models';
import { getErrMsg } from 'src/utils/simpler';
import { computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
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

const REQUEST_SORT_OPTIONS = [
  { value: 'requested_date', label: 'Tanggal Permintaan' },
  { value: 'transfer_at', label: 'Tanggal Transfer' },
];

/* TODO: Fix typings */
const getItemName = (item: MembershipRequest) => getMemberDisplayName({
  college: (item.membership.education_program as any).college,
  education_program: item.membership.education_program as any,
}, true);

const route = useRoute();
const router = useRouter();

const [isOverlayLoading, overlayLoading] = useLoading();

const sortBy = ref({
  field: 'requested_date' as typeof REQUEST_SORT_OPTIONS[number]['value'],
  desc: true,
});
const filter = ref({
  get status() {
    return (route.query.status ?? 'pending') as MembershipRequestStatus;
  },
  set status(value) {
    router.replace({ query: { status: value } });
  },
});

const { state: list, execute: refresh, isLoading: listLoading } = useAsyncState(
  () => adminService.membershipRequestList(filter.value.status),
  [],
);
const { data: _membershipRequestsStates } = useAdminMembershipRequestsStates();

const sortedList = computed(() => list.value.toSorted((a, b) => {
  if (sortBy.value.field === 'requested_date') {
    return (a.requested_date.getTime() - b.requested_date.getTime()) * (sortBy.value.desc ? -1 : 1);
  }

  return ((a.transfer_at?.getTime() ?? 0) - (b.transfer_at?.getTime() ?? 0)) * (sortBy.value.desc ? -1 : 1);
}));

const membershipRequestsStates = computed(() => Object.fromEntries(
  (_membershipRequestsStates.value || [])?.map((state) => [state.id, state]),
));

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
        validUntil: item.valid_until ?? endOfYear(item.amount ? addYears(new Date(), item.amount / MEMBERSHIP_FEE) : new Date()),
        amount: item.amount,
        /* TODO: Fix typings */
        registrationId: (item.membership as any).registration_id,
      },
    },
  })
    .onOk(async ({
      validStart, validUntil, registrationId, amount,
    }) => {
      try {
        await overlayLoading(
          adminService.membershipRequestApprove(item.id, {
            validStart: new Date(validStart),
            validUntil: new Date(validUntil),
            registrationId,
            amount,
          }),
        );
        refresh();
        filter.value.status = 'approved';
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

const onPatchInvoiceClick = async (item: MembershipRequest) => {
  try {
    Dialog.create({
      component: PatchInvoiceDialog,
      componentProps: {
        memberId: item.membership.id,
        requestId: item.id,
      },
    }).onOk(() => {
      refresh();
    });
  } catch (err) {
    Notify.create({ type: 'negative', message: getErrMsg(err) });
  }
};

watch(() => filter.value.status, () => refresh());
</script>

<template>
  <q-card>
    <q-card-section>
      <div class="flex justify-between items-center">
        <h6 class="my-0">
          Verifikasi Pembayaran
        </h6>

        <div class="flex gap-2">
          <q-btn
            :icon="sortBy.desc ? 'arrow_downward' : 'arrow_upward'"
            flat
            round
            @click="sortBy.desc = !sortBy.desc"
          />

          <q-select
            v-model="sortBy.field"
            label="Urutkan"
            :options="REQUEST_SORT_OPTIONS"
            rounded
            standout
            dense
            map-options
            emit-value
          />

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
      </div>

      <q-markup-table
        flat
        class="h-60vh"
      >
        <thead>
          <tr>
            <th class="text-left">
              <p class="my-0">
                Tanggal
              </p>
              <p class="my-0">
                Pengajuan
              </p>
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
              v-for="item in sortedList"
              :key="item.id"
            >
              <td class="text-left w-8ch">
                <div class="text-grey">
                  {{ item.requested_date.toLocaleString('id', { dateStyle: 'short' }) }}
                </div>

                <q-chip
                  v-if="item.valid_until ? item.valid_until < new Date() : false"
                  label="expired"
                  color="warning"
                  text-color="white"
                  size="sm"
                  outline
                  dense
                />
              </td>
              <td class="max-w-35ch truncate">
                <router-link
                  :to="{ name: 'Member', params: { memberId: item.membership.id } }"
                  target="_blank"
                >
                  {{ getItemName(item) }}
                  <q-icon name="open_in_new" />
                </router-link>
                <div class="text-sm text-blue-grey">
                  Tanggal transfer: {{ item.transfer_at?.toLocaleString('id') || '-' }}
                </div>
                <div class="text-sm text-blue-grey">
                  Nominal bayar:
                  <strong class="font-semibold">
                    {{ item.amount ? item.amount.toLocaleString('id', { style: 'currency', currency: 'IDR' }) : '-' }}
                  </strong>
                </div>
              </td>
              <td class="text-center w-6ch">
                <q-chip
                  :label="REQUEST_STATUS_LABELS[item.status]"
                  :color="REQUEST_STATUS_COLORS[item.status]"
                  text-color="white"
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
                        icon="receipt"
                        :to="{ name: 'DocumentInvoice', params: { invoiceId: membershipRequestsStates[item.id.toString()]?.invoice_id } }"
                        target="_blank"
                        :disable="!membershipRequestsStates[item.id.toString()]?.invoice_id"
                      >
                        <q-badge
                          v-if="!membershipRequestsStates[item.id.toString()]?.invoice_id"
                          label="!"
                          floating
                          color="red"
                          rounded
                        />
                      </q-btn>
                    </template>

                    <q-btn icon="more_vert">
                      <q-menu>
                        <q-list
                          dense
                          class="min-w-32"
                        >
                          <q-item
                            v-close-popup
                            v-ripple
                            clickable
                            :disable="item.status === 'pending'"
                            @click="onEditClick(item)"
                          >
                            <q-item-section>Edit</q-item-section>
                          </q-item>

                          <q-separator />

                          <q-item
                            v-close-popup
                            v-ripple
                            clickable
                            :disable="!!membershipRequestsStates[item.id.toString()]?.invoice_id"
                            @click="onPatchInvoiceClick(item)"
                          >
                            <q-item-section>Perbaiki Invoice</q-item-section>
                          </q-item>
                        </q-list>
                      </q-menu>
                    </q-btn>
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
