<template>
  <q-card class="relative-position bg-white">
    <div class="overlay absolute-full">
      <q-img
        src="/images/ICON_KPBI.png"
        fit="scale-down"
        class="overlay-img fit"
      />
    </div>

    <q-card-section class="row wrap gap-md">
      <div class="col-12">
        <h5 class="text-center">
          {{ computedData.jenjang }} PBIO {{ computedData.perguruanTinggi.singkatan }}
        </h5>
      </div>

      <q-list
        padding
        class="col-8 text-blue-grey-9 column"
      >
        <div class="row">
          <CardProfileItem
            v-model="computedData.jenjang"
            :edit-mode="editMode"
            label="Jenjang"
            icon="school"
            class="col-5"
          >
            <template #default="scope">
              <q-select
                :model-value="scope.value"
                :label="scope.label"
                :options="['S1', 'S2', 'S3']"
                :readonly="!scope.editMode"
                @update:model-value="scope.onUpdate"
              />
            </template>
          </CardProfileItem>

          <CardProfileItem
            v-model="computedData.namaProdi"
            label="Nama Prodi"
            :edit-mode="editMode"
            class="col-grow"
          />
        </div>

        <CardProfileItem
          v-model="computedData.jurusan"
          label="Nama Jurusan"
          :edit-mode="editMode"
          icon="grade"
        />

        <CardProfileItem
          v-model="computedData.fakultas"
          label="Fakultas"
          :edit-mode="editMode"
          icon="domain"
        />

        <div class="row">
          <CardProfileItem
            v-model="computedData.akreditasi.prodi.value"
            label="Akreditasi Prodi"
            :edit-mode="editMode"
            icon="verified"
            class="col-6"
          />
          <CardProfileItem
            v-model="computedData.akreditasi.prodi.tanggal"
            label="Tanggal Akreditasi"
            :edit-mode="editMode"
            type="date"
            class="col-6"
          />
        </div>

        <q-item-label
          header
          class="q-mt-md q-pt-md q-pb-none row items-center gap-x-md"
        >
          <q-icon
            name="map"
            size="xs"
            color="blue-grey-9"
          />
          <small>Alamat kampus</small>
        </q-item-label>

        <div class="q-pl-lg row">
          <CardProfileItem
            v-model="computedData.perguruanTinggi.alamat.alamat"
            label="Alamat"
            :edit-mode="editMode"
            class="col-12 q-pb-none"
          />

          <CardProfileItem
            v-model="computedData.perguruanTinggi.alamat.kota"
            label="Kota/Kabupaten"
            :edit-mode="editMode"
            class="col-6"
          />
          <CardProfileItem
            v-model="computedData.perguruanTinggi.alamat.provinsi"
            label="Provinsi"
            :edit-mode="editMode"
            class="col-6"
          />
        </div>

        <CardProfileItem
          v-model="computedData.emailProdi"
          label="Email Prodi"
          :edit-mode="editMode"
          icon="email"
        />

        <CardProfileItem
          v-model="computedData.webProdi"
          label="Website Prodi"
          :edit-mode="editMode"
          icon="web"
        />

        <CardProfileItem
          v-model="computedData.noHpProdi"
          label="Nomor Telpon Kantor"
          :edit-mode="editMode"
          icon="phone"
        />
      </q-list>

      <div class="col-3 column items-end">
        <q-img
          src="https://picsum.photos/300/300"
          width="150px"
          height="150px"
          fit="cover"
          class="rounded-borders"
        />

        <dl class="q-ma-none q-mt-sm text-center">
          <dt class="text-overline">
            Perguruan Tinggi
          </dt>
          <dd class="text-caption">
            {{ computedData.perguruanTinggi.lengkap }}
          </dd>
          <dd class="text-caption">
            ({{ computedData.perguruanTinggi.singkatan }})
          </dd>

          <dt class="text-overline">
            Akreditasi PT
          </dt>
          <dd class="text-caption">
            {{ computedData.akreditasi.perguruanTinggi }}
          </dd>

          <dt class="text-overline">
            Status PT
          </dt>
          <dd class="text-caption">
            {{ computedData.status }}
          </dd>
        </dl>
      </div>
    </q-card-section>

    <q-separator spaced />

    <q-card-section class="row wrap gap-md">
      <q-list
        padding
        class="col-8 text-blue-grey-9 column"
      >
        <CardProfileItem
          v-model="computedData.kaprodi.nama"
          label="Nama Kaprodi"
          :edit-mode="editMode"
          icon="person"
        />

        <div class="row">
          <CardProfileItem
            v-model="computedData.kaprodi.periode.mulai"
            label="Mulai menjabat"
            type="date"
            icon="date_range"
            :edit-mode="editMode"
            class="col-6"
          />
          <CardProfileItem
            v-model="computedData.kaprodi.periode.purna"
            label="Akhir jabatan"
            type="date"
            :edit-mode="editMode"
            class="col-6"
          />
        </div>

        <CardProfileItem
          v-model="computedData.kaprodi.email"
          label="Email Kaprodi"
          :edit-mode="editMode"
          icon="email"
        />

        <CardProfileItem
          v-model="computedData.kaprodi.noHp"
          label="Nomor HP Kaprodi"
          :edit-mode="editMode"
          icon="phone"
        />
      </q-list>

      <div class="col-3 column items-end">
        <q-img
          src="https://picsum.photos/300/300"
          width="150px"
          height="150px"
          fit="cover"
          class="rounded-borders"
        />
      </div>
    </q-card-section>
  </q-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import CardProfileItem from 'components/CardProfileItem.vue';
import type { PropType } from 'vue';
import type { Member } from 'app/common/schema';

export default defineComponent({
  name: 'CardProfile',
  components: {
    CardProfileItem,
  },
  props: {
    data: {
      type: Object as PropType<Member>,
      required: true,
    },
    editMode: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['update:data'],
  computed: {
    computedData: {
      get(): Member {
        return this.data;
      },
      set(v: Member) {
        this.$emit('update:data', v);
      },
    },
  },
});
</script>

<style lang="sass" scoped>
.overlay-img
  opacity: .1

dt
  margin-top: map-get($space-sm, y)
  color: $blue-grey-4
  line-height: 1.2

dd
  margin: 0
</style>
