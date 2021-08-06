<template>
  <q-dialog
    ref="dialogRef"
    persistent
    @hide="onDialogHide"
  >
    <q-card class="q-dialog-plugin full-width max-w-sm">
      <q-form>
        <q-card-section>
          <h6>{{ title }}</h6>
        </q-card-section>

        <q-card-section>
          <q-img
            :src="documentPreviewSrc"
            height="40vh"
          />

          <q-input
            v-model="editable.requestedMasaBerlaku"
            label="Masa keanggotaan yang diajukan"
            type="number"
            :hint="`Berlaku sampai ${requestedMasaBerlakuDate.toLocaleDateString()}`"
            required
          />

          <q-input
            v-model="editable.message"
            label="Kirim pesan (opsional)"
            type="textarea"
          />
        </q-card-section>

        <q-card-actions align="between">
          <q-btn
            label="Cancel"
            flat
            @click="onCancelClick"
          />
          <div class="row q-gutter-x-sm">
            <q-btn
              label="Tolak"
              color="negative"
              @click="onTolakClick"
            />
            <q-btn
              label="Terima"
              color="positive"
              @click="onTerimaClick"
            />
          </div>
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>

<script lang="ts">
import {
  defineComponent, reactive, computed,
} from 'vue';
import { useDialogPluginComponent, date } from 'quasar';
import type { VerificationRequestStatus } from 'app/common/schema';

export default defineComponent({
  name: 'ReviewDialog',
  props: {
    title: {
      type: String,
      default: 'Review verifikasi',
    },
    documentPreviewSrc: {
      type: String,
      default: 'https://via.placeholder/300',
    },
    requestedYear: {
      type: Number,
      default: 1,
    },
    message: {
      type: String,
      default: '',
    },
  },
  emits: [
    ...useDialogPluginComponent.emits,
  ],
  setup(props) {
    const {
      dialogRef, onDialogHide, onDialogOK, onDialogCancel,
    } = useDialogPluginComponent();
    const editable = reactive({
      requestedMasaBerlaku: props.requestedYear,
      message: props.message,
    });
    const requestedMasaBerlakuDate = computed(() => date
      .addToDate(new Date(), { years: editable.requestedMasaBerlaku }));
    const onOKClick = (status: VerificationRequestStatus) => onDialogOK({
      message: editable.message,
      masaBerlaku: requestedMasaBerlakuDate.value,
      status,
    });

    return {
      editable,
      requestedMasaBerlakuDate,
      // below is documented on https://next.quasar.dev/quasar-plugins/dialog#composition-api-variant
      dialogRef,
      onDialogHide,
      onTerimaClick: () => onOKClick('accept'),
      onTolakClick: () => onOKClick('decline'),
      onCancelClick: onDialogCancel,
    };
  },
});
</script>
