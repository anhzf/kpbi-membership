<template>
  <div class="full-width column items-center q-gutter-y-lg">
    <q-form
      class="full-width max-w-xs column"
      @submit.prevent="onSubmit"
    >
      <q-card
        flat
        bordered
      >
        <q-card-section class="q-gutter-y-lg">
          <q-uploader
            ref="uploader"
            label="Upload berkas bukti pembayaran"
            :factory="upload"
            accept=".jpeg, .jpg, .png"
            auto-upload
            class="full-width"
          />

          <q-input
            v-model="masaBerlaku"
            label="Masa keanggotaan yang diajukan (tahun)"
            type="number"
            :hint="`Berlaku sampai ${masaBerlakuDate.toLocaleDateString()}`"
            required
          />
        </q-card-section>

        <q-card-actions align="right">
          <div class="row justify-end">
            <q-btn
              label="Kirim permintaan verifikasi"
              type="submit"
              color="primary"
            />
          </div>
        </q-card-actions>
      </q-card>
    </q-form>

    <q-separator class="full-width" />

    <div class="full-width max-w-sm">
      <h6>Histori permintaan</h6>
    </div>

    <q-table
      :columns="reqHistoryColumnsDefinition"
      :rows="reqHistory"
      row-key="_uid"
      :loading="isReqHistoryLoading"
      flat
      bordered
      class="full-width max-w-sm"
    >
      <template #body-cell-action="props">
        <q-td :props="props">
          <q-btn
            icon="visibility"
            color="primary"
            round
            flat
            @click="() => openDocViewer(props.value)"
          >
            <q-tooltip>Lihat berkas</q-tooltip>
          </q-btn>

          <q-btn
            icon="delete"
            color="negative"
            round
            flat
          />
        </q-td>
      </template>
    </q-table>

    <q-dialog v-model="isDocViewerOpen">
      <q-img :src="docViewerSrc" />
    </q-dialog>
  </div>
</template>

<script lang="ts">
import {
  defineComponent, reactive, computed, toRefs,
} from 'vue';
import { date, Notify, QUploader } from 'quasar';
import fbs from 'src/firebaseService';
import { collections } from 'src/firestoreServices';
import { useStore } from 'src/store';
import VerificationRequestUseCase from 'src/useCases/verificationRequest';
import { useCollection } from 'src/use/firestore';
import { promiseProxy } from 'src/helpers';
import type fb from 'firebase';
import type { q } from 'src/types';
import type { Model, ModelInObject, VerificationRequest } from 'app/common/schema';

type reqHistoryModel = Pick<ModelInObject<Model<VerificationRequest>>, 'masaBerlaku' | '_uid' | '_created'>

const reqHistoryColumnsDefinition = [
  {
    name: 'uid',
    label: '#',
    field: '_uid',
    required: true,
    sortable: false,
    align: 'left',
    headerClasses: 'text-grey-6',
    classes: 'text-grey-8',
  },
  {
    name: 'timestamp',
    label: 'Tanggal Ajuan',
    field: '_created',
    format: (v: fb.firestore.Timestamp) => v.toDate().toLocaleDateString(),
    required: true,
    sortable: true,
    align: 'left',
  },
  {
    name: 'requested',
    label: 'Masa keanggotaan yang diajukan',
    field: 'masaBerlaku',
    format: (v: fb.firestore.Timestamp) => v.toDate().toLocaleDateString(),
    required: true,
    sortable: true,
    align: 'left',
  },
  {
    name: 'action',
    label: 'Action',
    field: '_uid',
    required: true,
    sortable: false,
  },
] as q.Table.ColumnDefinition<reqHistoryModel>[];

const defaultFormFill = {
  masaBerlaku: 1,
  uploadedDocument: undefined as (File | undefined),
};

export default defineComponent({
  name: 'RequestVerification',
  setup() {
    const store = useStore();
    const state = reactive({
      uploader: null as (QUploader | null),
      isDocViewerOpen: false,
      docViewerSrc: 'https://via.placeholder.com/200',
      ...defaultFormFill,
    });
    const reqHistoryQuery = computed(() => collections.VerificationRequest
      .where('userId', '==', store.state.auth.user?.uid || '')
      .where('_deleted', '==', null));
    const { data, isLoading, update } = useCollection(reqHistoryQuery);
    const masaBerlakuDate = computed(() => date
      .addToDate(new Date(), { years: state.masaBerlaku }));
    const upload = ([file]: File[]) => {
      state.uploadedDocument = file;
    };
    const updateReqHistory = promiseProxy(() => Promise.resolve(update()));
    const openDocViewer = async (reqId: string) => {
      const getDocViewSrcUrl = promiseProxy(() => VerificationRequestUseCase
        ._getDocumentPreviewUrl(reqId));
      state.isDocViewerOpen = true;
      state.docViewerSrc = await getDocViewSrcUrl() || 'https://via.placeholder.com/200';
    };
    const resetForm = () => {
      state.uploader?.reset();
      ({
        masaBerlaku: state.masaBerlaku,
        uploadedDocument: state.uploadedDocument,
      } = defaultFormFill);
    };
    const onSubmit = promiseProxy(() => {
      if (state.uploadedDocument) {
        return VerificationRequestUseCase.create(
          { masaBerlaku: fbs.firestore.Timestamp.fromDate(masaBerlakuDate.value) },
          state.uploadedDocument,
        )
          .then(() => {
            resetForm();
            Notify.create({ type: 'positive', message: 'Berhasil mengirim permintaan verifikasi!' });
            void updateReqHistory();
          });
      }

      throw new Error('Mohon pilih dokumen bukti pembayaran');
    });

    return {
      ...toRefs(state),
      reqHistory: data,
      isReqHistoryLoading: isLoading,
      reqHistoryColumnsDefinition,
      masaBerlakuDate,
      upload,
      openDocViewer,
      onSubmit,
    };
  },
});
</script>
