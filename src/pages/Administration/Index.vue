<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="full-width max-w-sm">
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
          v-if="$store.state.auth.isAdmin"
          name="pendingVerificationList"
          label="Permintaan Verifikasi"
        />
      </q-tabs>

      <q-separator />

      <q-tab-panels
        v-model="tab"
        animated
        keep-alive
      >
        <q-tab-panel name="verifyPayment">
          <request-verification />
        </q-tab-panel>

        <q-tab-panel
          v-if="$store.state.auth.isAdmin"
          name="pendingVerificationList"
          class="q-gutter-y-md"
        >
          <div class="full-width flex justify-end items-center q-gutter-x-md">
            <span class="text-subtitle-2 text-grey-5">Status: </span>

            <q-select
              v-model="statusSelected"
              :options="statusOptions"
              dense
            />
          </div>

          <div class="full-width">
            <pending-verification-list :where-status="statusSelected" />
          </div>
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import RequestVerification from 'pages/Administration/RequestVerification.vue';
import PendingVerificationList from 'pages/Administration/PendingVerificationList.vue';
import type { VerificationRequestStatus } from 'app/common/schema';

export default defineComponent({
  name: 'PageAdministration',
  components: { RequestVerification, PendingVerificationList },
  setup() {
    const state = reactive({
      tab: 'verifyPayment',
      statusSelected: 'pending' as VerificationRequestStatus,
    });

    return toRefs(state);
  },
  data: () => ({
    statusOptions: ['accept', 'decline', 'pending'] as VerificationRequestStatus[],
  }),
});
</script>
