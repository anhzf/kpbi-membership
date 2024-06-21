<script lang="ts" setup>
import memberService, { memberServiceBill } from 'src/services/member';
import { useAuthStore } from 'src/stores/auth';
import {
  computed, defineAsyncComponent,
  ref,
} from 'vue';
import { isFeatureAllowed } from 'src/services/features';
import InvoiceList from './InvoiceList.vue';
import MembershipRequest from './MembershipRequest.vue';

const VerifyMembership = defineAsyncComponent(() => import('./VerifyMembership.vue'));

const auth = useAuthStore();

memberService.get('me')
  .then(() => memberServiceBill());

const tab = ref('verifyPayment');
</script>

<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="w-full max-w-screen-md">
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
        <q-tab
          v-if="auth.user?.role && isFeatureAllowed(auth.user?.role, 'VerifyPayment')"
          name="pendingVerificationList"
          label="Permintaan Verifikasi"
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

        <q-tab-panel
          v-if="auth.user?.role && isFeatureAllowed(auth.user?.role, 'VerifyPayment')"
          name="pendingVerificationList"
          class="q-gutter-y-md"
        >
          <VerifyMembership flat />
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-page>
</template>
