<script lang="ts" setup>
import { MemberProfile } from 'src/types/models';

interface Props {
  accreditations: MemberProfile['education_program']['accreditations'];
  email?: string;
  phoneNumber?: string;
  externalLink?: string;
}

defineProps<Props>();
</script>

<template>
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
          v-for="accreditation in accreditations"
          :key="accreditation.id"
        >
          <q-item-section>
            <q-item-label overline>
              {{ accreditation.label }}
            </q-item-label>
            <q-item-label>
              <span class="text-h6 m-0">
                {{ accreditation.value }}
              </span>
            </q-item-label>
          </q-item-section>
          <q-item-section
            side
            top
          >
            <q-item-label caption>
              {{ accreditation.valid_from?.toLocaleDateString() }}—
            </q-item-label>
            <q-item-label caption>
              {{ accreditation.valid_until?.toLocaleDateString() }}
            </q-item-label>
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
                :href="`mailto:${email}`"
                target="_blank"
              >
                {{ email }}
              </a>
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Nomor Telpon kantor
            </q-item-label>
            <q-item-label>{{ phoneNumber }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Website
            </q-item-label>
            <q-item-label>
              <a
                :href="externalLink"
                target="_blank"
              >
                {{ externalLink }}
              </a>
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
  </q-card>
</template>
