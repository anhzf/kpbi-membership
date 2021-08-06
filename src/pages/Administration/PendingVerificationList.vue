<template>
  <q-table
    :rows="data"
    :columns="columnDefinitions"
    :pagination="pagination"
    flat
    bordered
    :loading="isDataLoading"
  >
    <template #body-cell-action="props">
      <q-td :props="props">
        <q-btn
          label="Review"
          color="secondary"
          @click="() => openReviewDialog(props.row._uid)"
        />
      </q-td>
    </template>
  </q-table>
</template>

<script lang="ts">
import {
  defineComponent, reactive, computed, toRefs,
} from 'vue';
import { Dialog, date, Notify } from 'quasar';
import ReviewDialog from 'pages/Administration/ReviewDialog.vue';
import { collections } from 'src/firestoreServices';
import VerificationRequestUseCase from 'src/useCases/verificationRequest';
import { useCollection } from 'src/use/firestore';
import { promiseProxy } from 'src/helpers';
import type fb from 'firebase';
import type { q } from 'src/types';
import type { Model, ModelInObject, VerificationRequest } from 'app/common/schema';

type WantedModel = ModelInObject<Model<VerificationRequest>> & {numb: number};

type ReviewDialogOKPayload = Pick<VerificationRequest, 'status' | 'message'> & {
  masaBerlaku: Date;
};

const columnDefinitions = [
  {
    label: '#',
    name: 'numb',
    required: true,
    align: 'left',
    field: 'numb',
    sortable: false,
    classes: 'text-blue-grey-13',
  },
  {
    label: 'USER',
    name: 'user',
    required: true,
    align: 'left',
    field: 'userId',
    sortable: true,
  },
  {
    label: 'TANGGAL AJUAN',
    name: 'date',
    required: true,
    align: 'right',
    field: '_updated',
    format: (v: fb.firestore.Timestamp) => v.toDate().toLocaleString(),
    sortable: true,
  },
  {
    label: 'AKSI',
    name: 'action',
    align: 'right',
    required: true,
    field: (row) => row._uid,
    sortable: false,
  },
] as q.Table.ColumnDefinition<WantedModel>[];

const pagination = {
  rowsPerPage: 10,
} as q.Table['pagination'];

export default defineComponent({
  name: 'PendingVerificationList',
  setup() {
    const { data, isLoading, update } = useCollection(collections
      .VerificationRequest
      .where('_deleted', '==', null)
      .where('status', '==', 'pending'));
    const mappedData = computed(() => data.value.map((el, numb) => ({ ...el, numb }) as WantedModel));
    const state = reactive({
      reviewing: '',
    });
    const verificationRequestUseCase = computed(() => {
      if (state.reviewing) {
        const model = collections.VerificationRequest.doc(state.reviewing);

        return new VerificationRequestUseCase(model);
      }

      return undefined;
    });
    type onUseCaseContextCb<R> = (ctx: VerificationRequestUseCase) => R;
    const onUseCaseContext = <R>(cb: onUseCaseContextCb<R>) => {
      if (verificationRequestUseCase.value) {
        return cb(verificationRequestUseCase.value);
      }

      throw new Error('Invalid arguments!');
    };
    const onCloseDialog = () => {
      state.reviewing = '';
    };
    const onReviewSuccess = () => {
      Notify.create({ type: 'positive', message: 'Berhasil memberi review!' });
      update();
    };
    type onReviewPayload = Omit<ReviewDialogOKPayload, 'status'>;
    type onReviewFn = (payload: onReviewPayload) => void | Promise<void>;
    // eslint-disable-next-line arrow-body-style
    const onReviewFactory = (fn: onReviewFn) => {
      return (payload: onReviewPayload) => {
        promiseProxy(() => Promise.resolve(fn(payload)))()
          .then(onReviewSuccess)
          .finally(onCloseDialog);
      };
    };
    const onAcceptReview = onReviewFactory((payload) => onUseCaseContext((useCase) => useCase.acceptReview(payload)));
    const onDeclineReview = onReviewFactory((payload) => onUseCaseContext((useCase) => useCase.declineReview(payload)));
    const openReviewDialog = (reqId: string) => {
      state.reviewing = reqId;

      void onUseCaseContext((useCase) => promiseProxy(async () => {
        const doc = await useCase.model.get();
        const model = doc.data();

        if (model) {
          const requestedYear = date.getDateDiff(model.masaBerlaku.toDate(), new Date(), 'years');

          Dialog.create({
            component: ReviewDialog,
            componentProps: {
              documentPreviewSrc: await useCase.getDocumentPreviewUrl(),
              requestedYear,
              message: model.message,
            },
          })
            .onOk(({ status, ...payload }: ReviewDialogOKPayload) => (status === 'accept'
              ? onAcceptReview(payload)
              : onDeclineReview(payload)))
            .onCancel(onCloseDialog)
            .onDismiss(onCloseDialog);
        } else throw new Error('Invalid arguments!');
      })());
    };

    return {
      ...toRefs(state),
      data: mappedData,
      isDataLoading: isLoading,
      columnDefinitions,
      pagination,
      openReviewDialog,
    };
  },
});
</script>
