import firebase from 'firebase/app';
import 'firebase/auth';
import 'firebase/firestore';

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

export {
  fbs as default,
  auth,
  db,
};
