import firebase from 'firebase/app';
import fbConfig from 'app/firebase.json';
import type fb from 'firebase';
import 'firebase/auth';
import 'firebase/firestore';
import 'firebase/storage';
import 'firebase/functions';

const emulatorHost = 'localhost';

const init = () => {
  if (firebase.apps.length) {
    firebase.app();
  } else {
    firebase.initializeApp(
      // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
      JSON.parse(atob(process.env.FIREBASE!)),
    );
  }

  const fbs = firebase;
  /* eslint-disable no-console */
  // all below services is trying to use emulator if in dev mode
  const auth = (() => {
    const fbAuth = fbs.auth();
    try {
      if (process.env.DEV) {
        const emulatorUrl = `http://${emulatorHost}:${fbConfig.emulators.auth.port}`;
        fbAuth.useEmulator(emulatorUrl);
      }
    } catch (err) { console.error(err); }

    return fbAuth;
  })();
  const db = (() => {
    const firestore = fbs.firestore();
    try {
      if (process.env.DEV) {
        firestore.useEmulator(emulatorHost, fbConfig.emulators.firestore.port);
      }
    } catch (err) { console.error(err); }

    return firestore;
  })();
  const storage = (() => {
    const fbStorage = fbs.storage();
    try {
      if (process.env.DEV) {
        fbStorage.useEmulator(emulatorHost, fbConfig.emulators.storage.port);
      }
    } catch (err) { console.error(err); }

    return fbStorage;
  })();
  const fns = (() => {
    const fbFunctions = fbs.functions();
    try {
      if (process.env.DEV) {
        fbFunctions.useEmulator(emulatorHost, fbConfig.emulators.functions.port);
      }
    } catch (err) { console.error(err); }

    return fbFunctions;
  })();
  /* eslint-enable no-console */

  return {
    fbs, auth, db, storage, fns,
  };
};

const {
  fbs,
  auth,
  db,
  storage,
  fns,
} = init();

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
  fns,
  isFirebaseError,
};
