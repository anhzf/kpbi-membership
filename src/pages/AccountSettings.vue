<template>
  <q-page
    padding
    class="column items-center"
  >
    <q-card class="account-settings-card">
      <q-list padding>
        <q-item>
          <q-item-section avatar>
            <q-icon name="check" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Terverifikasi</q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Email</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label>alwan.nuha7@gmail.com</q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label>Password</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-item-label>
              <q-btn
                label="Ubah password"
                icon="edit"
                flat
                size="sm"
              />
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'PageAccountSettings',
});
</script>

<style lang="scss" scoped>
.account-settings-card {
  width: 100%;
  max-width: $breakpoint-xs;
}
</style>
