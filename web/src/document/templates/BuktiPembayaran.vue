<script lang="ts" setup>
import { toCanvas } from 'qrcode';
import { insertAmount, set62SubTag } from 'src/utils/qris';
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { IMG_CAP_KPBI, IMG_TTD_BOWO_SUGIHARTO, KPBI_QRIS } from '../constants';

interface Props {
  payload: Record<string, unknown>;
}

const props = defineProps<Props>();

const route = useRoute();

// Forces view as invoice instead of receipt
const isShowInvoice = route.query.receipt === 'false';

// Extract data from unified document payload
const data = props.payload as {
  invoice_number: string;
  receipt_to: {
    addresses: string;
    membership_id: number;
    name: string;
  };
  item: {
    desc: string;
    name: string;
    price: number;
    qty: number;
  };
  created_at: string;
  due_at: string;
  paid_at?: string;
  contact_person: {
    email: string;
    name: string;
    phone_number: string;
    employee_id: string;
  };
  treasurer: {
    email: string;
    name: string;
    phone_number: string;
    employee_id: string;
  };
  formatted_dates: {
    invoice_date: string;
    due_date: string;
    created_year: number;
    due_date_formatted: string;
  };
  formatted_amounts: {
    price_per_unit: string;
    total_amount: string;
    total_in_words: string;
  };
  time_units: {
    years_text: string;
  };
};

const invoiceDate = isShowInvoice ? data.formatted_dates.due_date : data.formatted_dates.invoice_date;

const qrisText = set62SubTag(
  insertAmount(
    KPBI_QRIS,
    data.item.price * data.item.qty,
  ),
  '09',
  // no usecase for now, but just in case we need to add more info in the future
  JSON.stringify({
    invoice_number: data.invoice_number,
    membership_id: data.receipt_to.membership_id,
    receipt_to: data.receipt_to.name,
  }),
);
const [qrisImgUrl] = await Promise.all([
  toCanvas(qrisText, { margin: 0, errorCorrectionLevel: 'H' })
    .then((canvas) => {
      const ctx = canvas.getContext('2d');
      const txt = 'KPBI QRIS';
      const padding = 6;

      if (ctx) {
        ctx.font = '500 24px Roboto';
        const textWidth = ctx.measureText(txt).width;
        const textHeight = 24; // Approximate height
        const x = (canvas.width - textWidth) / 2;
        const y = (canvas.height + textHeight / 2) / 2;

        ctx.fillStyle = 'white';
        ctx.roundRect(x - padding, y - textHeight, textWidth + padding * 2, textHeight + padding, 8);
        ctx.fill();

        ctx.fillStyle = '#264122';
        ctx.fillText(txt, x, y);
      }

      return canvas.toDataURL();
    }),
]);

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
              <td>{{ data.formatted_dates.created_year }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Jumlah tahun
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ data.time_units.years_text }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Iuran per tahun
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ data.formatted_amounts.price_per_unit }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Jumlah total tagihan
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ data.formatted_amounts.total_amount }}</td>
            </tr>
            <tr>
              <td class="w-18ch">
                Terbilang
              </td>
              <td class="w-2ch">
                :
              </td>
              <td class="font-[Lucida_Handwriting] font-bold">
                {{ data.formatted_amounts.total_in_words }} rupiah
              </td>
            </tr>
            <tr>
              <td class="w-18ch">
                Tanggal jatuh tempo
              </td>
              <td class="w-2ch">
                :
              </td>
              <td>{{ data.formatted_dates.due_date_formatted }}</td>
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
          :src="qrisImgUrl"
          alt="QRIS KPBI"
          class="size-36"
        >
        <table class="font-serif">
          <tbody>
            <tr>
              <td class="relative leading-tight">
                <div>
                  Surakarta,
                  {{ isShowInvoice ? data.formatted_dates.due_date_formatted : data.formatted_dates.invoice_date }}
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
