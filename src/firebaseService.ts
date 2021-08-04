import firebase from 'firebase/app';
import type fb from 'firebase';
import 'firebase/auth';
import 'firebase/firestore';
import 'firebase/storage';

const fbs = (() => {
  if (firebase.apps.length) {
    firebase.app();
  } else {
    firebase.initializeApp(
      // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
      JSON.parse(atob(process.env.FIREBASE!)),
    );
  }

  return firebase;
})();

const auth = fbs.auth();
const db = fbs.firestore();
const storage = fbs.storage().ref();

/* eslint-disable @typescript-eslint/no-explicit-any, @typescript-eslint/no-unsafe-member-access */
const isFirebaseError = (data: any): data is fb.FirebaseError => typeof data.code === 'string'
  && typeof data.message === 'string'
  && typeof data.name === 'string';
/* eslint-enable @typescript-eslint/no-explicit-any, @typescript-eslint/no-unsafe-member-access */

export {
  fbs as default,
  auth,
  db,
  storage,
  isFirebaseError,
};
