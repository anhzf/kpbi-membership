<script lang="ts" setup>
import { useAuthStore } from 'src/stores/auth';
import { MemberProfile } from 'src/types/models';

interface Props {
  data: MemberProfile['responsible'];
}

defineProps<Props>();

const auth = useAuthStore();
</script>

<template>
  <q-card
    flat
    bordered
  >
    <q-card-section class="column">
      <div class="flex justify-between items-center gap-2">
        <h3 class="text-h6 m-0">
          Kepala Prodi
        </h3>
        <q-btn
          v-if="auth.user?.id === data.user.id"
          icon="edit"
          color="grey"
          flat
          round
          :to="{ name: 'AccountSettings' }"
        />
      </div>

      <q-avatar
        size="8rem"
        color="grey"
        class="self-center"
      >
        <q-img :src="data.user.img" />
      </q-avatar>

      <q-list class="mt-2">
        <q-item>
          <q-item-section>
            <q-item-label caption>
              Nama
            </q-item-label>
            <q-item-label>
              {{ data.user.name || '-' }}
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
                :href="data.user.email && `mailto:${data.user.email}`"
                target="_blank"
              >
                {{ data.user.email || '-' }}
              </a>
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Nomor HP
            </q-item-label>
            <q-item-label>{{ data.user.phone_number || '-' }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>
  </q-card>
</template>
