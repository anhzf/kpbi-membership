import { GuardType } from 'src/types';
import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        name: 'Home',
        component: () => import('pages/Index.vue'),
      },
      {
        path: 'login',
        name: 'Login',
        component: () => import('pages/Login.vue'),
        meta: { guard: 'no-auth' as GuardType },
      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('pages/Register.vue'),
        meta: { guard: 'no-auth' as GuardType },
      },
      {
        path: 'settings',
        name: 'AccountSettings',
        component: () => import('pages/AccountSettings.vue'),
        meta: { guard: 'auth' as GuardType },
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue'),
  },
];

export default routes;
