<template>
  <q-page
    padding
    class="column items-center"
  >
    <CardProfile
      v-model:data="data"
      :edit-mode="editMode"
      class="myprofile-card min-w-xs max-w-sm"
    />
    <q-page-sticky
      position="bottom-right"
      class="q-pa-lg"
    >
      <q-fab
        v-model="showFab"
        icon="keyboard_arrow_up"
        color="primary"
        direction="up"
        @before-hide="showFab = true"
      >
        <template v-if="editMode">
          <q-fab-action
            label="Batalkan perubahan"
            icon="delete_forever"
            color="negative"
            external-label
            label-position="left"
            @click="editMode = false"
          />
          <q-fab-action
            label="Simpan perubahan"
            icon="save"
            color="positive"
            external-label
            label-position="left"
            @click="editMode = false"
          />
        </template>

        <q-fab-action
          v-else
          label="Perbarui profil"
          icon="edit"
          color="info"
          external-label
          label-position="left"
          @click="editMode = true"
        />
      </q-fab>
    </q-page-sticky>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import { uid } from 'quasar';
import CardProfile from 'src/components/CardProfile.vue';
import fbs from 'src/firebaseService';
import type { Member, Model, ModelInObject } from 'app/common/schema';

export default defineComponent({
  name: 'PageMyProfile',
  components: {
    CardProfile,
  },
  setup() {
    const data = reactive({
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
        alamat: {
          alamat: 'Jl. Kahuripan Utara',
          kota: 'Bandung',
          provinsi: 'Jakarta',
        },
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
    } as ModelInObject<Model<Member>>);
    //     const akreditasiProdiTanggal = computed<string>({
    //       get() {
    //         return data.akreditasi.prodi.tanggal.toDate().toLocaleString('id');
    //       },
    //       set(v: string) {
    // // fbs.firestore.Timestamp.
    //       }
    //     })

    return {
      data,
    };
  },
  data() {
    return {
      editMode: false,
      showFab: true,
    };
  },
});
</script>

<style lang="sass">
.myprofile-card
  width: 100vmin
</style>
