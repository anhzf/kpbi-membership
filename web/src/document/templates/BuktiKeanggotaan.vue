<script lang="ts" setup>
import { toDataURL } from 'qrcode';
import { onMounted } from 'vue';
import { IMG_CAP_KPBI, IMG_TTD_BOWO_SUGIHARTO } from '../constants';

interface Props {
  payload: Record<string, unknown>;
}

const props = defineProps<Props>();

// Extract data from unified document payload
const data = props.payload as {
  membership_id: string;
  certificate_number: string;
  member_name: string;
  education_program: {
    name: string;
    faculty: string;
    degree: string;
    formatted_fullname: string;
  };
  college: {
    name: string | null;
  };
  validity: {
    start: string;
    end: string | null;
    start_formatted: string;
    end_formatted: string;
  };
  qr_text: string;
  registration_id: string | null;
  created_at: string;
  period_end: string;
};

// Use pre-computed values
const number = data.certificate_number;
const fullname = data.education_program.formatted_fullname;
const qrUrl = await toDataURL(data.qr_text, { margin: 0 });

// Ensure image are loaded
await (new Promise<void>((resolve, reject) => {
  const img = new Image();
  const onLoad = () => {
    resolve();
    img.removeEventListener('load', onLoad);
  };
  const onError = (err: unknown) => {
    reject(err);
    img.removeEventListener('error', onError);
  };
  img.addEventListener('load', onLoad);
  img.addEventListener('error', onError);
  img.src = '/images/membership-certificate-frame.webp';
}));

onMounted(() => {
  window.readyToPrint?.();
});
</script>

<template>
  <div
    class="w-full h-full flex flex-col flex-nowrap justify-center items-center gap-4 p-8 text-lg text-zinc-900 text-center
      bg-[url(/images/membership-certificate-frame.webp)] bg-no-repeat bg-contain [background-position-x:center] [background-position-y:center]"
  >
    <img
      src="/images/Optimized-ICON_KPBI.png"
      alt="Logo KPBI"
      class="h-44"
    >

    <div class="text-2xl font-bold">
      No: {{ number }}
    </div>

    <div class="text-4xl font-semibold uppercase">
      KONSORSIUM PENDIDIKAN BIOLOGI INDONESIA
    </div>

    <div class="font-serif">
      Menerangkan Bahwa
    </div>

    <div class="text-2xl font-serif font-semibold italic">
      {{ fullname }}
    </div>

    <div>
      <div class="font-serif">
        Adalah anggota Konsorsium Pendidikan Biologi Indonesia
      </div>

      <div class="font-serif">
        Periode {{ data.validity.start_formatted }}
        s.d. {{ data.validity.end_formatted }}
      </div>
    </div>

    <div class="self-stretch mt-2 flex justify-around">
      <img
        :src="qrUrl"
        alt="QR Keanggotaan"
        class="w-52 h-52"
      >

      <table class="font-serif">
        <tbody>
          <tr>
            <td class="relative leading-tight">
              <div>Surakarta, {{ data.validity.end_formatted }}</div>
              <div>Ketua</div>
              <div class="h-4.5em" />
              <div>Dr. Bowo Sugiharto, M.Pd.</div>
              <div>197601252005011001</div>

              <img
                :src="IMG_CAP_KPBI"
                alt=""
                class="absolute inset-y-1/2 left-0 h-22 -translate-1/2"
              >

              <img
                :src="IMG_TTD_BOWO_SUGIHARTO"
                alt=""
                class="absolute inset-1/2 h-32 -translate-1/2"
              >
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
