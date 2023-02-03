<script lang="ts" setup>
import { useAsyncState } from '@vueuse/core';
import memberService from 'src/services/member';
import { ACADEMIC_DEGREES_LABELS, COLLEGE_TYPES_LABELS } from 'src/types/constants';
import { useRoute } from 'vue-router';

const route = useRoute();
const { state: data } = useAsyncState(() => memberService.get(String(route.params.memberId)), undefined);
</script>

<!-- TODO: Refactor card section to components -->
<template>
  <q-page
    padding
    class="column"
  >
    <q-btn
      icon="arrow_back"
      flat
      round
      class="self-start"
      @click="$router.back"
    />

    <q-card
      v-if="data"
      flat
      class="self-center items-start w-full max-w-screen-lg"
    >
      <q-card-section class="row items-center gap-x-6">
        <q-avatar
          size="10rem"
          color="grey-5"
        >
          <q-img :src="data.college.img" />
        </q-avatar>

        <h1 class="column m-0">
          <span class="text-h3">
            {{ ACADEMIC_DEGREES_LABELS[data.education_program.degree] }} {{ data.education_program.name }}
          </span>
          <span class="text-h5 text-blue-grey-10">
            {{ data.college.name }} ({{ data.college.short_name }})
          </span>
          <p class="text-subtitle1 text-blue-grey">
            {{ data.education_program.department }}{{ data.education_program.faculty }}
          </p>
        </h1>
      </q-card-section>

      <q-card-section class="row q-col-gutter-sm">
        <div class="col-6">
          <q-card
            flat
            bordered
          >
            <q-card-section>
              <h3 class="text-h6 m-0">
                Program Pendidikan
              </h3>

              <q-list>
                <q-item-label header>
                  Akreditasi
                </q-item-label>
                <q-item
                  v-for="accreditation in data.education_program.accreditations"
                  :key="accreditation.id"
                >
                  <q-item-section>
                    <q-item-label>
                      <span class="text-h6 m-0">
                        {{ accreditation.value }}
                      </span>
                    </q-item-label>
                    <q-item-label caption>
                      {{ [accreditation.valid_from, accreditation.valid_until]
                        .filter(Boolean)
                        .map(el=>el?.toLocaleDateString())
                        .join(' – ') }}
                    </q-item-label>
                  </q-item-section>
                  <q-item-section
                    side
                    top
                  >
                    <q-item-section caption>
                      {{ accreditation.label }}
                    </q-item-section>
                  </q-item-section>
                </q-item>

                <q-separator />

                <q-item-label header>
                  Kontak
                </q-item-label>
                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Email kantor
                    </q-item-label>
                    <q-item-label>
                      <a
                        :href="`mailto:${data.education_program.email}`"
                        target="_blank"
                      >
                        {{ data.education_program.email }}
                      </a>
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Nomor Telpon kantor
                    </q-item-label>
                    <q-item-label>{{ data.education_program.phone_number }}</q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Website
                    </q-item-label>
                    <q-item-label>
                      <a
                        :href="data.education_program.external_link"
                        target="_blank"
                      >
                        {{ data.education_program.external_link }}
                      </a>
                    </q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-card-section>
          </q-card>
        </div>

        <div class="col-6">
          <q-card
            flat
            bordered
          >
            <q-card-section>
              <h3 class="text-h6 m-0">
                Kampus
              </h3>

              <q-list>
                <q-item-label header>
                  Akreditasi
                </q-item-label>
                <q-item
                  v-for="accreditation in data.college.accreditations"
                  :key="accreditation.id"
                >
                  <q-item-section>
                    <q-item-label>
                      <span class="text-h6 m-0">
                        {{ accreditation.value }}
                      </span>
                    </q-item-label>
                    <q-item-label caption>
                      {{ [accreditation.valid_from, accreditation.valid_until].filter(Boolean).join(' – ') }}
                    </q-item-label>
                  </q-item-section>
                  <q-item-section
                    side
                    top
                  >
                    <q-item-section caption>
                      {{ accreditation.label }}
                    </q-item-section>
                  </q-item-section>
                </q-item>

                <q-separator />

                <q-item-label header>
                  Umum
                </q-item-label>

                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Alamat
                    </q-item-label>
                    <q-item-label>
                      {{ [data.college.street_address, data.college.city, data.college.province].join(', ') }}
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Status
                    </q-item-label>
                    <q-item-label>{{ COLLEGE_TYPES_LABELS[data.college.type] }}</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-card-section>
          </q-card>
        </div>

        <div class="col-6">
          <q-card
            flat
            bordered
          >
            <q-card-section class="column">
              <h3 class="text-h6 m-0">
                Kepala Prodi
              </h3>

              <q-avatar
                size="8rem"
                color="grey"
                class="self-center"
              >
                <q-img :src="data.responsible.user.img" />
              </q-avatar>

              <q-list class="mt-2">
                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Nama
                    </q-item-label>
                    <q-item-label>
                      {{ data.responsible?.user.name }}
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Email
                    </q-item-label>
                    <q-item-label>
                      <a
                        :href="`mailto:${data.responsible.user.email}`"
                        target="_blank"
                      >
                        {{ data.responsible.user.email }}
                      </a>
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label caption>
                      Nomor HP
                    </q-item-label>
                    <q-item-label>{{ data.responsible.user.phone_number }}</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-card-section>
          </q-card>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>
