<template>
  <q-page
    padding
    class="column q-gutter-md"
  >
    <q-input
      v-model="search"
      label="Cari disini..."
      dense
    >
      <template #append>
        <q-icon name="search" />
      </template>
    </q-input>

    <ListTableMember
      :data="data"
      :filter="search"
    />
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import { uid } from 'quasar';
import ListTableMember from 'src/components/ListTableMember.vue';
import fbs from 'src/firebaseService';
import type { Member, Model, ModelInObject } from 'app/common/schema';

export default defineComponent({
  name: 'PageIndex',

  components: { ListTableMember },

  setup() {
    const state = reactive({
      search: '',
    });

    return {
      ...toRefs(state),
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
            mulai: fbs.firestore.Timestamp.now(),
            purna: fbs.firestore.Timestamp.now(),
          },
        },
        akreditasi: {
          prodi: {
            value: 'A',
            tanggal: fbs.firestore.Timestamp.now(),
            internasional: '-',
          },
          perguruanTinggi: 'Belum Terakreditasi',
        },
        _created: fbs.firestore.Timestamp.now(),
        _updated: fbs.firestore.Timestamp.now(),
        _deleted: null,
      } as ModelInObject<Model<Member>>)),
    };
  },
});
</script>
