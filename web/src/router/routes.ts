import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout'),
    children: [
      {
        path: '',
        name: 'Home',
        component: () => import('pages/IndexPage.vue'),
      },
      {
        path: 'login',
        name: 'Login',
        component: () => import('pages/LoginPage.vue'),
        meta: { guard: 'guest' },
      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('pages/RegisterPage'),
        meta: { guard: 'guest' },
      },
      {
        path: 'forgot',
        name: 'ForgotPassword',
        component: () => import('pages/ForgotPasswordPage.vue'),
        meta: { guard: 'guest' },
      },
      {
        path: 'reset-password',
        name: 'ResetPassword',
        component: () => import('pages/ResetPasswordPage.vue'),
        meta: { guard: 'guest' },
      },
      {
        path: 'profil-saya',
        name: 'MyProfile',
        component: () => import('pages/MyProfilePage.vue'),
        meta: { guard: 'auth' },
      },
      {
        path: 'settings',
        name: 'AccountSettings',
        component: () => import('pages/AccountSettingsPage.vue'),
        meta: { guard: 'auth' },
      },
      {
        path: 'membership',
        name: 'Membership',
        component: () => import('src/pages/MyMembershipPage'),
        meta: { guard: 'auth' },
      },
      {
        path: 'member/:memberId',
        name: 'Member',
        component: () => import('pages/MemberProfilePage.vue'),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
