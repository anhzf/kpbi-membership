import type { GuardType } from 'src/types/common';

declare module 'vue-router' {
  interface RouteMeta {
    guard?: GuardType;
  }
}
