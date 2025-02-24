<script lang="ts" setup>
import { toDataURL } from 'qrcode';
import memberService from 'src/services/member';
import { ACADEMIC_DEGREES_LABELS } from 'src/types/constants';
import { onMounted } from 'vue';
import { IMG_CAP_KPBI, IMG_TTD_BOWO_SUGIHARTO } from './constants';

interface Props {
  memberId: string;
}

const props = defineProps<Props>();

const member = await memberService.get(props.memberId);
if (!member) throw new Error('Data not found');

const requests = await memberService.listRequestOf(member.id);
const request = requests.findLast((r) => r.status === 'approved');
if (!request) throw new Error('Data not found');

const number = [
  (member.registration_id || member.id).toString().padStart(3, '0'),
  Number(member.created_at.getMonth().toString().padStart(2, '0')) + 1,
  'KPBI',
  member.created_at.getFullYear(),
].join('/');

const fullname = [
  `${ACADEMIC_DEGREES_LABELS[member.education_program.degree]} ${member.education_program.name}`,
  member.education_program.faculty,
  member.college.name,
].filter(Boolean).join(', ');

const qrUrl = await toDataURL(
  `Prodi ${fullname} keanggotaan berlaku mulai ${member.created_at.toLocaleString('id', { dateStyle: 'long' })} s.d. ${request!.valid_until?.toLocaleString('id', { dateStyle: 'long' })} dengan nomor keanggotaan ${number}`,
  { margin: 0 },
);

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
        Periode {{ (request!.valid_start ?? member!.created_at).toLocaleString('id', {dateStyle:'long'}) }}
        s.d. {{ request!.valid_until?.toLocaleString('id', {dateStyle:'long'}) }}
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
              <div>Surakarta, {{ request!.authorized_at?.toLocaleString('id', {dateStyle: 'long'}) }}</div>
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
