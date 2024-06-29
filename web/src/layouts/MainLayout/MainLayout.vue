<script lang="ts" setup>
import { Loading, Notify } from 'quasar';
import { api } from 'src/services/utils';
import { useAuthStore } from 'src/stores/auth';
import { getErrMsg } from 'src/utils/simpler';
import { ref, computed, watch } from 'vue';
import { RouterLinkProps, useRouter, useRoute } from 'vue-router';
import { AxiosError } from 'axios';
import AsyncState from 'src/components/AsyncState.vue';
import memberService, { getMemberDisplayName } from 'src/services/member';
import { isFeatureAllowed, type Feature } from 'src/services/features';
import DefineState from 'src/components/DefineState.vue';
import SideNavItem from './SideNavItem.vue';

interface INavItem extends Partial<RouterLinkProps> {
  title: string;
  icon?: string;
  featureName?: Feature;
  [key: string]: unknown;
}

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

const publicNavItems: INavItem[] = [
  {
    title: 'Anggota Terdaftar',
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
    title: 'Profil Keanggotaan',
    icon: 'perm_identity',
    to: { name: 'Member', params: { memberId: 'me' } },
    exact: true,
  },
  {
    title: 'Status Keanggotaan',
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

const adminNavItems: INavItem[] = [
  {
    featureName: 'ManageUsers',
    title: 'Kelola Pengguna',
    icon: 'people',
    to: { name: 'admin:ManageUsers' },
  },
];

const leftDrawerOpen = ref(false);
const authorizedNavItems = computed(() => (auth.user ? authNavItems : guestNavItems));
const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};

// Call callback_url if it exists then remove it from query. If the callback needs auth, redirect to login.
watch([() => auth.isReady, () => route.query.callback_url], async ([isReady, callbackUrl]) => {
  if (isReady && typeof callbackUrl === 'string') {
    try {
      Loading.show();
      const url = callbackUrl.startsWith('/') && api.defaults.baseURL
        ? callbackUrl.replace(new URL(api.defaults.baseURL!).pathname, '')
        : callbackUrl;

      const { data, statusText } = await api.post(url);

      router.replace({ query: { callback_url: undefined } });

      Notify.create({
        type: 'positive',
        message: data.message ?? statusText,
      });
    } catch (err) {
      if ((err instanceof AxiosError)
      && (err.response?.status === 401)) {
        router.push({ name: 'Login', query: { callback_url: callbackUrl } });
        Notify.create({
          type: 'negative',
          message: 'Silahkan login terlebih dahulu',
        });
      } else {
        router.replace({ query: { callback_url: undefined } });

        Notify.create({
          type: 'negative',
          message: getErrMsg(err),
        });
      }
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
          Keanggotaan KPBI
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
          <template v-if="auth.user">
            <q-item-section avatar>
              <q-avatar>
                <q-img :src="auth.user.img" />
              </q-avatar>
            </q-item-section>

            <q-item-section>
              <q-item-label class="text-weight-medium">
                {{ auth.user.name }}
              </q-item-label>
              <AsyncState
                :value="memberService.get('me')"
                :init="null"
                #="{state}"
              >
                <q-item-label
                  v-if="state"
                  caption
                >
                  {{ getMemberDisplayName(state, true) }}
                </q-item-label>
              </AsyncState>
            </q-item-section>
          </template>

          <template v-else>
            <q-item-section avatar>
              <q-avatar>
                <q-img src="/images/Optimized-ICON_KPBI__no-text.png" />
              </q-avatar>
            </q-item-section>

            <q-item-section>
              <q-item-label class="text-weight-medium">
                KPBI
              </q-item-label>
              <q-item-label caption>
                Anda belum login
              </q-item-label>
            </q-item-section>
          </template>
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

          <DefineState
            v-if="auth.user?.role"
            :value="adminNavItems.filter((item) => (item.featureName
              ? isFeatureAllowed(auth.user!.role!, item.featureName)
              : true))"
            #="{states: [navItems]}"
          >
            <template v-if="navItems.length">
              <q-separator spaced />

              <q-item-label header>
                Admin
              </q-item-label>

              <SideNavItem
                v-for="navItem in navItems"
                :key="navItem.title"
                v-bind="navItem"
              />
            </template>
          </DefineState>
        </template>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>
