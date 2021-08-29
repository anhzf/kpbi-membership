/* eslint-disable camelcase */
import type fb from 'firebase';
import type * as fbAdmin from 'firebase-admin';

export type NodeSchemeOf<T> = {
  [K in keyof T]: T[K] extends fb.firestore.Timestamp
    ? fbAdmin.firestore.Timestamp
    : T[K];
}

export interface LegacyUser {
  id: number;
  name: string;
  email: string;
  role: string;
  verified: boolean;
  created_at: string;
  updated_at: string;
}
