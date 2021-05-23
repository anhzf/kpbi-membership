<template>
  <q-table
    :columns="columnDefinitions"
    :rows="data"
    row-key="action"
    :pagination="pagination"
  />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { uid } from 'quasar';
import firebase from 'firebase';
import type { q } from 'src/types';
import type { Member, Model, ModelInObject } from 'app/common/schema';

const columnDefinitions = [
  {
    label: '#',
    name: 'numb',
    required: true,
    align: 'left',
    field: (row) => row.numb,
    sortable: false,
  },
  {
    label: 'JENJANG',
    name: 'jenjang',
    required: true,
    align: 'left',
    field: (row) => row.jenjang,
    sortable: true,
  },
  {
    label: 'PRODI',
    name: 'namaProdi',
    align: 'left',
    required: true,
    field: (row) => row.namaProdi,
    sortable: true,
  },
  {
    label: 'PERGURUAN TINGGI',
    name: 'pt',
    align: 'left',
    required: true,
    field: (row) => row.perguruanTinggi.lengkap,
    sortable: true,
  },
  {
    label: 'WEBSITE PRODI',
    name: 'webProdi',
    align: 'left',
    required: true,
    field: (row) => row.webProdi,
    sortable: false,
  },
  {
    label: 'AKSI',
    name: 'action',
    align: 'right',
    required: true,
    field: (row) => row._uid,
    sortable: false,
  },
] as q.Table.ColumnDefinition<ModelInObject<Model<Member>> & {numb: number}>[];

const pagination = {
  rowsPerPage: 10,
} as q.Table['pagination'];

export default defineComponent({
  name: 'ListTableMember',
  setup() {
    return {
      data: Array.from(Array(10), (el, i) => ({
        numb: i,
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
      } as ModelInObject<Model<Member>> & {numb: number})),
      columnDefinitions,
      pagination,
    };
  },
});
</script>
