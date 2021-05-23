<template>
  <q-page
    padding
    class="cols"
  >
    <ListTableMember :data="data" />
  </q-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { uid } from 'quasar';
import firebase from 'firebase';
import ListTableMember from 'src/components/ListTableMember.vue';
import type { Member, Model, ModelInObject } from 'app/common/schema';

export default defineComponent({
  name: 'PageIndex',
  components: { ListTableMember },
  setup() {
    return {
      data: Array.from(Array(10), () => ({
        _uid: uid(),
        jenjang: 'S1',
        namaProdi: 'Pendidikan Biologi',
        status: 'NEGERI',
        jurusan: '-',
        fakultas: 'Pertanian',
        webProdi: 'https://google.com',
        noHpProdi: '+62851XXXXX',
        emailProdi: 'anh.dev7@gmail.com',
        perguruanTinggi: {
          singkatan: 'UNS',
          lengkap: 'Universitas Sebelas Maret',
          alamat: 'Jl. Kahuripan Utara',
        },
        kaprodi: {
          nama: 'JokowiDodo',
          noHp: '+62XXXXXXX',
          email: 'gmail@yahoo.com',
          periode: {
            mulai: firebase.firestore.Timestamp.now(),
            purna: firebase.firestore.Timestamp.now(),
          },
        },
        akreditasi: {
          prodi: {
            value: 'A',
            tanggal: firebase.firestore.Timestamp.now(),
            internasional: '-',
          },
          perguruanTinggi: 'Belum Terakreditasi',
        },
        _created: firebase.firestore.Timestamp.now(),
        _updated: firebase.firestore.Timestamp.now(),
        _deleted: null,
      } as ModelInObject<Model<Member>>)),
    };
  },
});
</script>
