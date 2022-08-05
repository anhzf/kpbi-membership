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

<script lang="ts" setup>
import { ref } from 'vue';

const onSubmit = () => {
  //
};
</script>
