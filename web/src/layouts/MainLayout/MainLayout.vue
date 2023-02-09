<script lang="ts" setup>
import { Loading, Notify } from 'quasar';
import { api } from 'src/services/utils';
import { useAuthStore } from 'src/stores/auth';
import { getErrMsg } from 'src/utils/simpler';
import { ref, computed, watch } from 'vue';
import { RouterLinkProps, useRouter, useRoute } from 'vue-router';
import SideNavItem from './SideNavItem.vue';

interface INavItem extends Partial<RouterLinkProps> {
  title: string;
  icon?: string;
  [key: string]: unknown;
}

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();
const publicNavItems: INavItem[] = [
  {
    title: 'Daftar Anggota',
    icon: 'group',
    to: { name: 'Home' },
    exact: true,
  },
];

const guestNavItems: INavItem[] = [
  {
    title: 'Login',
    icon: 'login',
    to: { name: 'Login' },
    exact: true,
  },
];

const authNavItems: INavItem[] = [
  {
    title: 'Profil Saya',
    icon: 'perm_identity',
    to: { name: 'MyProfile' },
    exact: true,
  },
  {
    title: 'Keanggotaan Saya',
    icon: 'card_membership',
    to: { name: 'Membership' },
    exact: true,
  },
  {
    title: 'Pengaturan Akun',
    icon: 'settings',
    to: { name: 'AccountSettings' },
    exact: true,
  },
  {
    title: 'Logout',
    icon: 'logout',
    onClick: () => auth.logout(),
  },
];
const leftDrawerOpen = ref(false);
const authorizedNavItems = computed(() => (auth.user ? authNavItems : guestNavItems));
const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};

// Call callback_url if it exists
watch([() => auth.isReady, () => route.query.callback_url], async ([isReady, callbackUrl]) => {
  if (isReady && typeof callbackUrl === 'string') {
    try {
      Loading.show();
      const { data, statusText } = await api.post(callbackUrl);

      router.replace({ query: { callback_url: undefined } });

      Notify.create({
        type: 'positive',
        message: data.message ?? statusText,
      });
    } catch (err) {
      Notify.create({
        type: 'negative',
        message: getErrMsg(err),
      });
    } finally {
      Loading.hide();
    }
  }
});
</script>

<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          KPBI
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      class="bg-grey-1"
    >
      <q-bar
        dense
        class="bg-primary"
      />

      <q-list>
        <q-item class="q-pt-lg q-pb-md">
          <q-item-section avatar>
            <q-img src="/images/Optimized-ICON_KPBI__no-text.png" />
          </q-item-section>

          <q-item-section class="text-weight-medium">
            KPBI
          </q-item-section>
        </q-item>

        <q-separator spaced />

        <template v-if="false">
          <q-item
            v-for="i in 3"
            :key="i"
          >
            <q-item-section>
              <q-skeleton type="rect" />
            </q-item-section>
          </q-item>

          <q-separator spaced />

          <q-item>
            <q-item-section>
              <q-skeleton type="rect" />
            </q-item-section>
          </q-item>
        </template>

        <template v-else>
          <SideNavItem
            v-for="navItem in authorizedNavItems"
            :key="navItem.title"
            v-bind="navItem"
          />

          <q-separator spaced />

          <SideNavItem
            v-for="navItem in publicNavItems"
            :key="navItem.title"
            v-bind="navItem"
          />
        </template>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>
