<script lang="ts" setup>
import memberService, { memberServiceBill } from 'src/services/member';
import {
  ref,
} from 'vue';
import InvoiceList from './InvoiceList.vue';
import MembershipRequest from './MembershipRequest.vue';

memberService.get('me')
  .then(() => memberServiceBill());

const tab = ref('verifyPayment');
</script>

<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="w-full max-w-screen-lg">
      <q-tabs
        v-model="tab"
        active-color="primary"
        indicator-color="primary"
        narrow-indicator
        :breakpoint="0"
        align="left"
        class="text-grey"
      >
        <q-tab
          name="verifyPayment"
          label="Verifikasi keanggotaan"
        />
        <q-tab
          name="invoiceList"
          label="Tagihan"
        />
      </q-tabs>

      <q-separator />

      <q-tab-panels
        v-model="tab"
        animated
      >
        <q-tab-panel name="verifyPayment">
          <MembershipRequest />
        </q-tab-panel>

        <q-tab-panel name="invoiceList">
          <InvoiceList flat />
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-page>
</template>
