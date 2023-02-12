<script lang="ts" setup>
interface Props {
  img?: string;
  name?: string;
  email?: string;
  phoneNumber?: string;
}

defineProps<Props>();
</script>

<template>
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
        <q-img :src="img" />
      </q-avatar>

      <q-list class="mt-2">
        <q-item>
          <q-item-section>
            <q-item-label caption>
              Nama
            </q-item-label>
            <q-item-label>
              {{ name }}
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
              Nomor HP
            </q-item-label>
            <q-item-label>{{ phoneNumber }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
  </q-card>
</template>
