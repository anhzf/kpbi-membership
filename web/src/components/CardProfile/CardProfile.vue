<template>
  <q-card class="relative-position bg-white">
    <q-form>
      <div class="overlay absolute-full">
        <q-img
          src="/images/Optimized-ICON_KPBI.png"
          fit="scale-down"
          class="overlay-img fit"
        />
      </div>

      <q-card-section class="row wrap gap-md">
        <div class="col-12">
          <h5 class="text-center">
            {{ data.jenjang }} PBIO {{ data.perguruanTinggi.singkatan }}
          </h5>
        </div>

        <q-list
          padding
          class="col-8 text-blue-grey-9 column"
        >
          <div class="row">
            <card-profile-item
              v-model="data.jenjang"
              :edit-mode="editMode"
              label="Jenjang"
              icon="school"
              class="col-5"
            >
              <template #default="scope">
                <q-select
                  v-if="scope.editMode"
                  :model-value="scope.value"
                  :label="scope.label"
                  :options="JENJANG_PRODI.concat()"
                  :readonly="!scope.editMode"
                  @update:model-value="scope.onUpdate"
                />

                <q-input
                  v-else
                  :model-value="scope.value"
                  :label="scope.label"
                  :readonly="!scope.editMode"
                  @update:model-value="(v) => scope.onUpdate(String(v))"
                />
              </template>
            </card-profile-item>

            <card-profile-item
              v-model="data.namaProdi"
              label="Nama Prodi"
              :edit-mode="editMode"
              class="col-grow"
            />
          </div>

          <card-profile-item
            v-if="editMode || data.jurusan"
            v-model="data.jurusan"
            label="Nama Jurusan"
            :edit-mode="editMode"
            icon="grade"
          />

          <card-profile-item
            v-model="data.fakultas"
            label="Fakultas"
            :edit-mode="editMode"
            icon="domain"
          />

          <div class="row">
            <card-profile-item
              v-model="data.akreditasi.value"
              label="Akreditasi Prodi"
              :edit-mode="editMode"
              icon="verified"
              class="col-6"
            />
            <card-profile-item
              v-model="data.akreditasi.tanggal"
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
            <card-profile-item
              v-model="data.perguruanTinggi.alamat.alamat"
              label="Alamat"
              :edit-mode="editMode"
              class="col-12 q-pb-none"
            />

            <card-profile-item
              v-model="data.perguruanTinggi.alamat.kota"
              label="Kota/Kabupaten"
              :edit-mode="editMode"
              class="col-6"
            />
            <card-profile-item
              v-model="data.perguruanTinggi.alamat.provinsi"
              label="Provinsi"
              :edit-mode="editMode"
              class="col-6"
            />
          </div>

          <card-profile-item
            v-model="data.emailProdi"
            label="Email Prodi"
            :edit-mode="editMode"
            icon="email"
          />

          <card-profile-item
            v-model="data.link"
            label="Website Prodi"
            type="url"
            :edit-mode="editMode"
            icon="web"
            :input-bind="{rules: [urlRule]}"
          />

          <card-profile-item
            v-model="data.noHpProdi"
            label="Nomor Telpon Kantor"
            :edit-mode="editMode"
            icon="phone"
          />
        </q-list>

        <div class="col-3 q-mx-auto column items-center">
          <q-img
            :src="data.perguruanTinggi.img"
            width="150px"
            height="150px"
            fit="cover"
            class="rounded-borders"
          >
            <div
              v-if="editMode"
              class="img-uploader-overlay column fit justify-center items-center"
            >
              <input
                ref="pTImgUploader"
                type="file"
                multiple
                accept=".jpg,.jpeg,.png"
                class="opacity-0 absolute-full cursor-pointer fit"
                @change="onPTImgUploaderChange"
              >

              <q-btn
                icon="upload"
                round
                color="secondary"
                @click="pTImgUploader?.click"
              />
            </div>
          </q-img>

          <dl class="q-mt-sm text-center">
            <dt class="text-overline">
              Perguruan Tinggi
            </dt>
            <dd class="text-caption">
              {{ data.perguruanTinggi.lengkap }}
            </dd>
            <dd class="text-caption">
              ({{ data.perguruanTinggi.singkatan }})
            </dd>

            <dt class="text-overline">
              Akreditasi PT
            </dt>
            <dd class="text-caption">
              {{ data.perguruanTinggi.akreditasi }}
            </dd>

            <dt class="text-overline">
              Status PT
            </dt>
            <dd class="text-caption">
              {{ data.perguruanTinggi.status }}
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
          <card-profile-item
            v-model="data.kaprodi.nama"
            label="Nama Kaprodi"
            :edit-mode="editMode"
            icon="person"
          />

          <div class="row">
            <card-profile-item
              v-model="data.kaprodi.periode.mulai"
              label="Mulai menjabat"
              type="date"
              icon="date_range"
              :edit-mode="editMode"
              class="col-6"
            />
            <card-profile-item
              v-model="data.kaprodi.periode.purna"
              label="Akhir jabatan"
              type="date"
              :edit-mode="editMode"
              class="col-6"
            />
          </div>

          <card-profile-item
            v-model="data.kaprodi.email"
            label="Email Kaprodi"
            :edit-mode="editMode"
            icon="email"
          />

          <card-profile-item
            v-model="data.kaprodi.noHp"
            label="Nomor HP Kaprodi"
            :edit-mode="editMode"
            icon="phone"
          />
        </q-list>

        <div class="col-3 column items-end">
          <q-img
            :src="data.kaprodi.img"
            width="150px"
            height="150px"
            fit="cover"
            class="rounded-borders"
          >
            <div
              v-if="editMode"
              class="img-uploader-overlay column fit justify-center items-center"
            >
              <input
                ref="kaprodiImgUploader"
                type="file"
                accept=".jpg,.jpeg,.png"
                class="opacity-0 absolute-full cursor-pointer fit"
                @change="onKaprodiImgUploaderChange"
              >

              <q-btn
                icon="upload"
                round
                color="secondary"
                @click="kaprodiImgUploader?.click"
              />
            </div>
          </q-img>
        </div>
      </q-card-section>
    </q-form>
  </q-card>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { urlRule } from 'src/utils/input-rules';
import { JENJANG_PRODI } from 'src/constants';
import * as mocks from 'src/mocks';
import type { MemberDetails } from 'src/types/models';
import CardProfileItem from './CardProfileItem.vue';

withDefaults(defineProps<{
  id: string,
  editMode?: boolean;
}>(), {
  editMode: false,
});

const data = ref<MemberDetails>(mocks.members[0]);
const pTImgUploader = ref<HTMLInputElement | null>(null);
const kaprodiImgUploader = ref<HTMLInputElement | null>(null);

const onPTImgUploaderChange = () => {
  //
};

const onKaprodiImgUploaderChange = () => {
  //
};
</script>

<style lang="sass" scoped>
@use "sass:color"

.overlay-img
  opacity: .1

.img-uploader-overlay
  background-color: color.change($blue-grey, $alpha: .1)
  transition: background-color .2s ease
  &:hover
    background-color: color.change($blue-grey, $alpha: .4)

dt
  margin-top: map-get($space-sm, y)
  color: $blue-grey-4
  line-height: 1.2

dd
  margin: 0
</style>
