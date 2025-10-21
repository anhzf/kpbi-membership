<script setup lang="ts">
import { Notify, useDialogPluginComponent } from 'quasar';
import { useMembership, useMembershipInvoices } from 'src/queries/membership';
import { computed, ref } from 'vue';
import { MEMBERSHIP_INVOICE_ITEM_NAME } from 'src/constants';
import { currencyFmt } from 'src/utils/number';
import { useAdminMembershipRequestsStates, useAttachMembershipRequestToInvoice } from 'src/queries/admin';
import DefineState from 'src/components/DefineState.vue';
import { getErrMsg } from 'src/utils/simpler';

interface Props {
  memberId: string;
  requestId: string;
}

const props = defineProps<Props>();

defineEmits([...useDialogPluginComponent.emits]);

const {
  dialogRef, onDialogHide, onDialogOK, onDialogCancel,
} = useDialogPluginComponent();

const selectedInvoiceId = ref('');
const detailsDialogActiveId = ref('');

const { data: membership, isFetching: isMembershipLoading } = useMembership(props.memberId);
const { data: invoices, isFetching: isInvoicesLoading } = useMembershipInvoices(() => membership.value?.id ?? '');

const { data: _membershipRequestsStates } = useAdminMembershipRequestsStates();
const {
  mutateAsync: attachMembershipRequestToInvoice, isPending: isSaving,
} = useAttachMembershipRequestToInvoice();

const detailsDialogActiveData = computed<{ label: string, value: any, badge?: boolean | string; }[]>(() => {
  const data = invoices.value.find((invoice) => invoice.id === detailsDialogActiveId.value);
  if (!data) return [];
  return [
    { label: 'ID', value: `#${data.id}` },
    { label: 'Tanggal', value: data.created_at },
    { label: 'Nominal Tagihan/Terbayar', value: currencyFmt.format(data.total) },
    { label: 'Subjek', value: data.receipt_to_details.name },
    { label: 'Alamat', value: data.receipt_to_details.addresses || '-' },
    { label: 'Biaya Tahunan', value: currencyFmt.format(data.items[MEMBERSHIP_INVOICE_ITEM_NAME]!.price) },
    { label: 'Jumlah Tahun Terbayar', value: `${data.items[MEMBERSHIP_INVOICE_ITEM_NAME]?.qty} tahun` },
    { label: 'Dibayar Pada', value: data.paid_at || '-' },
    { label: 'Jatuh Tempo', value: data.due_at },
    { label: 'Status', value: data.paid_at ? 'Terbayar' : 'Belum Bayar', badge: data.paid_at ? 'positive' : 'warning' },
  ];
});

const membershipRequestOfInvoice = computed<Record<string, string>>(() => Object.fromEntries(
  (_membershipRequestsStates.value || [])
    .map((state) => [state.invoice_id, state.id])
    .filter(([invoiceId]) => invoiceId),
));

const onSelectInvoiceClick = (id: string) => {
  selectedInvoiceId.value = selectedInvoiceId.value === id ? '' : id;
};

const onSubmit = async () => {
  try {
    await attachMembershipRequestToInvoice({
      invoiceId: selectedInvoiceId.value,
      membershipRequestId: props.requestId,
    });

    onDialogOK();
  } catch (error) {
    Notify.create({
      type: 'negative',
      message: 'Error patching invoice',
      caption: getErrMsg(error),
    });
  }
};
</script>

<template>
  <q-dialog
    ref="dialogRef"
    @hide="onDialogHide"
  >
    <q-card class="w-full !max-w-$q-size-sm">
      <q-form @submit="onSubmit">
        <q-card-section>
          <div class="text-h6">
            Pilih Invoice
          </div>
        </q-card-section>

        <q-card-section>
          <q-markup-table
            v-if="!isMembershipLoading && !isInvoicesLoading"
            flat
            dense
            class="min-h-xs"
          >
            <thead>
              <tr>
                <th class="text-center w-4ch text-grey-7">
                  #
                </th>
                <th class="text-left">
                  Tanggal
                </th>
                <th class="text-right w-16">
                  Nominal Tagihan
                </th>
                <th class="text-right w-48" />
              </tr>
            </thead>
            <tbody>
              <DefineState
                v-for="invoice in invoices"
                :key="invoice.id"
                :value="!!membershipRequestOfInvoice[invoice.id]"
                #="{ state: [isAttachedMembershipRequest] }"
              >
                <tr
                  :class="['relative select-none', {
                    'bg-grey-2': selectedInvoiceId === invoice.id,
                    'opacity-50': isAttachedMembershipRequest,
                    'cursor-pointer': !isAttachedMembershipRequest,
                  }]"
                  @click="isAttachedMembershipRequest || onSelectInvoiceClick(invoice.id)"
                >
                  <td class="text-center text-grey-7">
                    {{ invoice.id }}
                  </td>
                  <td class="text-left">
                    {{ invoice.created_at.toLocaleString('id-ID', { dateStyle: 'long' }) }},
                    <span class="text-grey-7">
                      {{ invoice.created_at.toLocaleString('id-ID', { timeStyle: 'short' }) }}
                    </span>
                  </td>
                  <td class="text-right">
                    {{ invoice.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }}
                  </td>
                  <td class="text-right">
                    <div class="row justify-end gap-2">
                      <q-btn
                        icon="visibility"
                        dense
                        flat
                        @click.stop="detailsDialogActiveId = invoice.id"
                      />
                      <q-btn
                        :label="selectedInvoiceId === invoice.id ? 'Batal Pilih' : 'Pilih'"
                        dense
                        :outline="selectedInvoiceId === invoice.id"
                        :color="selectedInvoiceId === invoice.id ? 'accent' : 'primary'"
                        @click.stop="isAttachedMembershipRequest || onSelectInvoiceClick(invoice.id)"
                      />
                    </div>
                  </td>
                </tr>
              </DefineState>
            </tbody>
          </q-markup-table>

          <div
            v-else
            class="h-32 flex flex-col justify-center items-center"
          >
            <q-spinner
              color="primary"
              size="2em"
            />
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions align="right">
          <q-btn
            label="Batal"
            color="primary"
            flat
            @click="onDialogCancel"
          />
          <q-btn
            label="Simpan"
            type="submit"
            color="primary"
            :loading="isSaving"
            :disable="!selectedInvoiceId || isSaving"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>

  <q-dialog
    :model-value="!!detailsDialogActiveId"
    position="bottom"
    @update:model-value="detailsDialogActiveId = $event ? detailsDialogActiveId : ''"
  >
    <q-card class="w-full">
      <q-card-section class="row justify-between">
        <h6 class="q-ma-none">
          Detail #{{ detailsDialogActiveId }}
        </h6>
      </q-card-section>
      <q-card-section class="min-h-40vh">
        <q-markup-table
          flat
          dense
          wrap-cells
        >
          <tbody>
            <tr
              v-for="el in detailsDialogActiveData"
              :key="el.label"
            >
              <td class="text-weight-medium text-grey-7 w-16">
                {{ el.label }}
              </td>
              <td>
                <template v-if="(el.value instanceof Date)">
                  {{ el.value.toLocaleString('id-ID', { dateStyle: 'long' }) }},
                  <span class="text-grey-7">
                    {{ el.value.toLocaleString('id-ID', { timeStyle: 'short' }) }}
                  </span>
                </template>
                <template v-else-if="el.badge">
                  <q-badge
                    dense
                    :color="typeof el.badge === 'string' ? el.badge : undefined"
                  >
                    {{ el.value }}
                  </q-badge>
                </template>
                <template v-else>
                  {{ el.value }}
                </template>
              </td>
            </tr>
          </tbody>
        </q-markup-table>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn
          icon="print"
          :to="{ name: 'DocumentInvoice', params: { invoiceId: detailsDialogActiveId } }"
          target="_blank"
          flat
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
