import * as fbAdmin from 'firebase-admin';

export const admin = (() => {
  const app = fbAdmin.initializeApp();

  return () => app;
})();

export const auth = admin().auth();

export const db = admin().firestore();
