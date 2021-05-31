import { isFirebaseError } from 'src/firebaseService';

// eslint-disable-next-line @typescript-eslint/no-explicit-any
export const getErrMsg = (err: any, withCode = false) => {
  if (isFirebaseError(err)) {
    return withCode
      ? `(${err.code}) ${err.message}`
      : err.message;
  }

  if (err instanceof Error) {
    return withCode
      ? `(${err.name}) ${err.message}`
      : err.message;
  }

  return String(err);
};
