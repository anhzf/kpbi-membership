<script lang="ts" setup>
import { toDataURL } from 'qrcode';
import { invoiceGetDocumentPayload } from 'src/services/invoice';
import { toDateTimeUnit, toIndonesianWords } from 'src/utils/number';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { IMG_CAP_KPBI, IMG_TTD_BOWO_SUGIHARTO } from './constants';
import { useRoute } from 'vue-router';

const DATE_TIME_UNITS = {
  tahun: 365 * 24 * 3600_000,
  bulan: 30 * 24 * 3600_000,
  pekan: 7 * 24 * 3600_000,
  hari: 24 * 3600_000,
  jam: 3600_000,
  menit: 60_000,
  detik: 1000,
};

interface Props {
  invoiceId: string;
}

const formatCurrency = (amount: number) => `${amount.toLocaleString('id', {
  style: 'currency', currency: 'IDR', minimumFractionDigits: 0,
}).replace(/\u00A0/g, ' ')},-`;

const props = defineProps<Props>();

const route = useRoute();
const router = useRouter();

// Forces view as invoice instead of receipt
const isShowInvoice = route.query.receipt === 'false';

const data = await invoiceGetDocumentPayload(props.invoiceId);
if (!data) throw new Error('Data not found');

const invoiceDate = (isShowInvoice ? data.due_at : data.created_at)
  .toLocaleString('id-ID', { dateStyle: 'long' });

const invoiceLink = `${window.location.origin}${router.resolve({ name: 'DocumentInvoice', params: { memberId: props.invoiceId } }).href}`;

const qrUrl = await toDataURL(invoiceLink, { margin: 0 });

onMounted(() => {
  window.readyToPrint?.();
});
</script>

<template>
  <div class="w-full h-full p-6 flex flex-col shadow-xl">
    <header class="pb-4 flex justify-center items-center gap-4 border-b-double">
      <img
        src="/images/Optimized-ICON_KPBI.png"
        alt="Logo KPBI"
        class="h-28"
      >

      <div class="flex flex-col text-center">
        <h1 class="text-h6 q-my-none">
          KONSORSIUM PENDIDIKAN BIOLOGI INDONESIA (KPBI)
        </h1>
        <div>Sekretariat: Program Studi Pendidikan Biologi FKIP UNS</div>
        <div>Lantai .3 gd. D FKIP UNS, Jl. Ir. Sutami 36 A Kentingan, Surakarta 57126</div>
        <div>Akta Kementrian Hukum dan HAM No AHU-0003253.AH.01.07</div>
      </div>
    </header>

    <div class="relative text-center p-2 font-serif">
      <h2 class="text-h5 q-my-none">
        INVOICE
      </h2>
      <div>No: INV-{{ data.invoice_number }}, Tanggal: {{ invoiceDate }}</div>

      <div class="absolute-top-right">
        <div
          class="q-ma-sm q-px-md q-py-sm text-white font-semibold border-2 border-inside"
          :class="(!isShowInvoice && data.paid_at) ? 'bg-emerald-500/75 border-emerald-500' : 'bg-red-500/75 border-red-500'"
        >
          {{ (!isShowInvoice && data.paid_at) ? 'PAID' : 'UNPAID' }}
        </div>
      </div>
    </div>

    <main class="py-4 flex flex-col gap-4 font-serif">
      <div class="">
        <p class="q-my-sm">
          Kepada Yth. Kaprodi
        </p>
        <p class="q-my-sm">
          <strong>{{ data.receipt_to.name }}</strong>
        </p>
        <p class="q-my-sm">
          <strong>{{ data.receipt_to.addresses }}</strong>
        </p>
      </div>

      <div class="flex flex-col">
        <p>
          Berikut kami sampaikan informasi tagihan iuran keanggotaan Konsorsium Pendidikan Biologi Indonesia (KPBI).
        </p>

        <table class="border border-2">
          <thead>
            <tr>
              <th
                rowspan="3"
                class="text-left pt-2 pb-3"
              >
                Informasi Tagihan
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="w-18ch">
                Rincian tahun tertagih
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ data.due_at.getFullYear() }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Jumlah tahun
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ toDateTimeUnit(data.item.qty * 365 * 24 * 3600_000, DATE_TIME_UNITS) }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Iuran per tahun
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ formatCurrency(data.item.price) }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Jumlah total tagihan
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ formatCurrency(data.item.price * data.item.qty) }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Terbilang
              </td>
              <td class="w-2ch">
                :
              </td>
              <td class="font-[Lucida_Handwriting] font-bold">
                {{ toIndonesianWords(data.item.price * data.item.qty) }} rupiah
              </td>
            </tr>
            <tr>
              <td class="w-18ch">
                Tanggal jatuh tempo
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ data.due_at.toLocaleString('id', { dateStyle: 'long' }) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div>
        <p>
          Mohon pembayaran dilakukan sebelum tanggal jatuh tempo. Silakan gunakan nomor invoice sebagai referensi
          pembayaran.
        </p>
        <p>
          Metode Pembayaran: Transfer via Rek <strong>BNI</strong>, No Rek: <strong>1684558753</strong> a.n.
          <strong>KPBI</strong>
        </p>
      </div>

      <p>
        Terima kasih atas keanggotaan Anda di organisasi KPBI.
      </p>

      <div class="self-stretch mt-2 flex justify-around">
        <img
          :src="qrUrl"
          alt="QR Keanggotaan"
          class="w-32 h-32"
        >
        <table class="font-serif">
          <tbody>
            <tr>
              <td class="relative leading-tight">
                <div>
                  Surakarta,
                  {{ (isShowInvoice ? data.due_at : (data.paid_at || data.due_at))?.toLocaleString('id', { dateStyle: 'long' }) }}
                </div>
                <div>Ketua</div>
                <div class="h-4.5em" />
                <div>{{ data.contact_person.name }}</div>
                <div>NIP {{ data.contact_person.employee_id ?? '<NIP>' }}</div>

                <img
                  :src="IMG_CAP_KPBI"
                  alt=""
                  class="absolute inset-y-1/2 left-0 h-22 -translate-1/2 -z-1"
                >

                <img
                  :src="IMG_TTD_BOWO_SUGIHARTO"
                  alt=""
                  class="absolute inset-1/2 h-24 -translate-1/2"
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <footer class="mt-4 py-2 font-serif">
      <div>Catatan:</div>
      <ol class="q-my-none">
        <li>
          Apabila terdapat kesalahan data harap hubungi Ketua KPBI ({{ data.contact_person.name }})
        </li>
        <li>
          Bukti Transfer harap dikirimkan ke Bendahara KPBI ({{ data.treasurer.name }} <a
            :href="data.treasurer.phone_number"
            target="_blank"
          >{{ data.treasurer.phone_number }}</a>)
        </li>
      </ol>
    </footer>
  </div>
</template>
