import { GuardType } from 'src/types';
import 'vue-router';

declare module 'vue-router' {
  interface RouteMeta {
    guard?: GuardType;
  }
 }
