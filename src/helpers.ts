import { Loading, Notify } from 'quasar';
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

type noArgsPromiseFn<R = unknown> = () => Promise<R>;

export const promiseProxy = function <R> (promiseFn: noArgsPromiseFn<R>) {
  const onError = (err: unknown) => {
    // eslint-disable-next-line no-console
    console.error(err);
    Notify.create({ type: 'negative', message: getErrMsg(err) });
  };

  return (() => {
    Loading.show();
    try {
      const invokeResult = promiseFn()
        .then((res) => res)
        .catch(onError)
        .finally(() => {
          Loading.hide();
        });

      return invokeResult;
    } catch (err) {
      Loading.hide();
      return onError(err);
    }
  }) as noArgsPromiseFn<R>;
};
