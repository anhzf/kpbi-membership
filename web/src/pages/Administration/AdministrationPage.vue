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
          v-if="isAdmin"
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
          v-if="isAdmin"
          name="pendingVerificationList"
          class="q-gutter-y-md"
        >
          <div class="full-width flex justify-end items-center q-gutter-x-md">
            <span class="text-subtitle-2 text-grey-5">Status: </span>

            <q-select
              v-model="statusSelected"
              :options="[...VERIFICATION_REQUEST_STATUS]"
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

<script lang="ts" setup>
import { ref } from 'vue';
import { VERIFICATION_REQUEST_STATUS } from 'src/constants';

const isAdmin = ref(true);
const tab = ref('verifyPayment');
const statusSelected = ref('PENDING');
</script>
