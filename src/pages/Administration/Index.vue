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
      >
        <q-tab-panel name="verifyPayment">
          <request-verification />
        </q-tab-panel>

        <q-tab-panel
          v-if="$store.state.auth.isAdmin"
          name="pendingVerificationList"
        >
          <pending-verification-list />
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import RequestVerification from 'pages/Administration/RequestVerification.vue';
import PendingVerificationList from 'pages/Administration/PendingVerificationList.vue';

export default defineComponent({
  name: 'PageAdministration',
  components: { RequestVerification, PendingVerificationList },
  setup() {
    const state = reactive({
      tab: 'verifyPayment',
    });

    return toRefs(state);
  },

});
</script>
