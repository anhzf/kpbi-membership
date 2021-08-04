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
            {{ computedData.jenjang }} PBIO {{ computedData.perguruanTinggi.singkatan }}
          </h5>
        </div>

        <q-list
          padding
          class="col-8 text-blue-grey-9 column"
        >
          <div class="row">
            <card-profile-item
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
            </card-profile-item>

            <card-profile-item
              v-model="computedData.namaProdi"
              label="Nama Prodi"
              :edit-mode="editMode"
              class="col-grow"
            />
          </div>

          <card-profile-item
            v-model="computedData.jurusan"
            label="Nama Jurusan"
            :edit-mode="editMode"
            icon="grade"
          />

          <card-profile-item
            v-model="computedData.fakultas"
            label="Fakultas"
            :edit-mode="editMode"
            icon="domain"
          />

          <div class="row">
            <card-profile-item
              v-model="computedData.akreditasi.prodi.value"
              label="Akreditasi Prodi"
              :edit-mode="editMode"
              icon="verified"
              class="col-6"
            />
            <card-profile-item
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
            <card-profile-item
              v-model="computedData.perguruanTinggi.alamat.alamat"
              label="Alamat"
              :edit-mode="editMode"
              class="col-12 q-pb-none"
            />

            <card-profile-item
              v-model="computedData.perguruanTinggi.alamat.kota"
              label="Kota/Kabupaten"
              :edit-mode="editMode"
              class="col-6"
            />
            <card-profile-item
              v-model="computedData.perguruanTinggi.alamat.provinsi"
              label="Provinsi"
              :edit-mode="editMode"
              class="col-6"
            />
          </div>

          <card-profile-item
            v-model="computedData.emailProdi"
            label="Email Prodi"
            :edit-mode="editMode"
            icon="email"
          />

          <card-profile-item
            v-model="computedData.webProdi"
            label="Website Prodi"
            type="url"
            :edit-mode="editMode"
            icon="web"
            :input-bind="{rules: [urlRule]}"
          />

          <card-profile-item
            v-model="computedData.noHpProdi"
            label="Nomor Telpon Kantor"
            :edit-mode="editMode"
            icon="phone"
          />
        </q-list>

        <div class="col-3 q-mx-auto column items-center">
          <q-img
            :src="uploadedPTImg || ptImgSrc"
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
                @click="() => pTImgUploader?.click()"
              />
            </div>
          </q-img>

          <dl class="q-mt-sm text-center">
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
          <card-profile-item
            v-model="computedData.kaprodi.nama"
            label="Nama Kaprodi"
            :edit-mode="editMode"
            icon="person"
          />

          <div class="row">
            <card-profile-item
              v-model="computedData.kaprodi.periode.mulai"
              label="Mulai menjabat"
              type="date"
              icon="date_range"
              :edit-mode="editMode"
              class="col-6"
            />
            <card-profile-item
              v-model="computedData.kaprodi.periode.purna"
              label="Akhir jabatan"
              type="date"
              :edit-mode="editMode"
              class="col-6"
            />
          </div>

          <card-profile-item
            v-model="computedData.kaprodi.email"
            label="Email Kaprodi"
            :edit-mode="editMode"
            icon="email"
          />

          <card-profile-item
            v-model="computedData.kaprodi.noHp"
            label="Nomor HP Kaprodi"
            :edit-mode="editMode"
            icon="phone"
          />
        </q-list>

        <div class="col-3 column items-end">
          <q-img
            :src="uploadedKaprodiImg || kaprodiImgSrc"
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
                @click="() => kaprodiImgUploader?.click()"
              />
            </div>
          </q-img>
        </div>
      </q-card-section>
    </q-form>
  </q-card>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from 'vue';
import CardProfileItem from 'components/CardProfileItem.vue';
import { urlRule } from 'src/inputRules';
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
    ptImgSrc: {
      type: String,
      default: 'https://via.placeholder.com/150',
    },
    kaprodiImgSrc: {
      type: String,
      default: 'https://via.placeholder.com/150',
    },
  },
  emits: ['update:data', 'selectPTImg', 'selectKaprodiImg'],
  setup() {
    const state = reactive({
      copyOfData: {} as Member,
      uploadedPTImg: '',
      uploadedKaprodiImg: '',
      pTImgUploader: undefined as (HTMLInputElement | undefined),
      kaprodiImgUploader: undefined as (HTMLInputElement | undefined),
    });

    return { ...toRefs(state), urlRule };
  },
  computed: {
    computedData: {
      get(): Member {
        return this.copyOfData;
      },
      set(v: Member) {
        // this.copyOfData = v;
        this.$emit('update:data', v);
      },
    },
  },
  watch: {
    data: {
      handler(v: Member) {
        this.copyOfData = v;
      },
      immediate: true,
    },
  },
  methods: {
    onPTImgUploaderChange(e: InputEvent) {
      const [file] = Array.from((e.currentTarget as HTMLInputElement).files ?? []);
      this.$emit('selectPTImg', file);
      this.uploadedPTImg = URL.createObjectURL(file);
    },
    onKaprodiImgUploaderChange(e: InputEvent) {
      const [file] = Array.from((e.currentTarget as HTMLInputElement).files ?? []);
      this.$emit('selectKaprodiImg', file);
      this.uploadedKaprodiImg = URL.createObjectURL(file);
    },
    resetUploadedImg() {
      this.uploadedPTImg = '';
      this.uploadedKaprodiImg = '';
    },
  },
});
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
