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

        <template v-if="$store.state.auth.isWaiting">
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
          <template v-if="$store.state.auth.user">
            <SideNavbarItem
              v-for="navItem in authNavItems"
              :key="navItem.title"
              v-bind="navItem"
            />
          </template>
          <template v-else>
            <SideNavbarItem
              v-for="navItem in guestNavItems"
              :key="navItem.title"
              v-bind="navItem"
            />
          </template>

          <q-separator spaced />

          <SideNavbarItem
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

<script lang="ts">
import {
  defineComponent, reactive, toRefs,
} from 'vue';
import { Loading, Notify } from 'quasar';
import SideNavbarItem from 'components/SideNavbarItem.vue';
import { auth } from 'src/firebaseService';
import { getErrMsg } from 'src/helpers';
import type { RouteLocationRaw } from 'vue-router';

interface INavItem {
  title: string;
  to?: RouteLocationRaw;
  icon?: string;
  [key: string]: unknown;
}

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
    title: 'Pengaturan Akun',
    icon: 'settings',
    to: { name: 'AccountSettings' },
    exact: true,
  },
  {
    title: 'Logout',
    icon: 'logout',
    onClick: () => {
      Loading.show();
      auth.signOut()
        .catch((err) => Notify
          .create({ message: getErrMsg(err, true), type: 'positive' }))
        .finally(() => Loading.hide());
    },
  },
];

export default defineComponent({
  name: 'MainLayout',

  components: {
    SideNavbarItem,
  },

  setup() {
    const state = reactive({
      leftDrawerOpen: false,
    });

    return {
      publicNavItems,
      guestNavItems,
      authNavItems,
      ...toRefs(state),
      toggleLeftDrawer() {
        state.leftDrawerOpen = !state.leftDrawerOpen;
      },
    };
  },
});
</script>
