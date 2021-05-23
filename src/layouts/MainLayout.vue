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

        <SideNavbarItem
          v-for="navItem in navItems"
          :key="navItem.title"
          v-bind="navItem"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import SideNavbarItem from 'components/SideNavbarItem.vue';
import type { RouteLocationRaw } from 'vue-router';

interface INavItem {
  title: string;
  to?: RouteLocationRaw;
  icon?: string;
}

const navItems: INavItem[] = [
  {
    title: 'Login',
    icon: 'login',
    to: { name: 'Login' },
  },
  {
    title: 'Daftar Anggota',
    icon: 'group',
    to: { name: 'Home' },
  },
];

export default defineComponent({
  name: 'MainLayout',

  components: {
    SideNavbarItem,
  },

  setup() {
    const leftDrawerOpen = ref(false);

    return {
      navItems,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
    };
  },
});
</script>
