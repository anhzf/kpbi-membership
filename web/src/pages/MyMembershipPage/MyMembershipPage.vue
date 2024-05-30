<script lang="ts" setup>
import { useAuthStore } from 'src/stores/auth';
import {
  computed, defineAsyncComponent, onMounted, ref,
} from 'vue';
import { memberServiceBill } from 'src/services/member';
import MembershipRequest from './MembershipRequest.vue';

const VerifyMembership = defineAsyncComponent(() => import('./VerifyMembership.vue'));

const auth = useAuthStore();

const isAdmin = computed(() => auth.user?.role === 'admin');
const tab = ref('verifyPayment');

onMounted(() => {
  memberServiceBill();
});
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
          v-if="isAdmin"
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
          <membership-request />
        </q-tab-panel>

        <q-tab-panel
          v-if="isAdmin"
          name="pendingVerificationList"
          class="q-gutter-y-md"
        >
          <verify-membership flat />
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-page>
</template>
