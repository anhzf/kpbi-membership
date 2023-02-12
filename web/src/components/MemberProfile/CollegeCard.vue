<script lang="ts" setup>
import { COLLEGE_TYPES_LABELS } from 'src/types/constants';
import { College } from 'src/types/models';

interface Props {
  accreditations: College['accreditations'];
  streetAddress: College['street_address'];
  city: College['city'];
  province: College['province'];
  kind: College['type'];
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
        Kampus
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
          Umum
        </q-item-label>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Alamat
            </q-item-label>
            <q-item-label>
              {{ [streetAddress, city, province].join(', ') }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Status
            </q-item-label>
            <q-item-label>{{ COLLEGE_TYPES_LABELS[kind] }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
  </q-card>
</template>
