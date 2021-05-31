/* eslint-disable no-unused-vars */
import type { GuardType } from 'src/types';

declare module 'vue-router' {
  interface RouteMeta {
    guard?: GuardType;
  }
}
