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
        meta: { guard: 'no-auth' },
      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('pages/Register.vue'),
        meta: { guard: 'no-auth' },
      },
      {
        path: 'forgot',
        name: 'ForgotPassword',
        component: () => import('pages/ForgotPassword.vue'),
        meta: { guard: 'no-auth' },
      },
      {
        path: 'profil-saya',
        name: 'MyProfile',
        component: () => import('pages/MyProfile.vue'),
        meta: { guard: 'auth' },
      },
      {
        path: 'settings',
        name: 'AccountSettings',
        component: () => import('pages/AccountSettings.vue'),
        meta: { guard: 'auth' },
      },
      {
        path: 'admin',
        name: 'Administration',
        component: () => import('pages/Administration/Index.vue'),
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
