import { Loading, Notify, type QLoadingShowOptions } from 'quasar';
import { getErrMsg } from 'src/utils/simpler';

export const pageLoading = async <T>(promise: Promise<T>, opts?: QLoadingShowOptions): Promise<T> => {
  const hide = Loading.show(opts);
  return promise.finally(() => {
    hide();
  });
};

export const toastErrorIfAny = async <T>(promise: Promise<T>): Promise<T> => promise
  .catch((err) => {
    Notify.create({
      type: 'negative',
      message: getErrMsg(err),
      actions: [
        {
          label: 'Log to console',
          handler: () => console.log({ err }),
        },
      ],
    });
    return Promise.reject(err);
  });

export const toastResponse = async <T>(promise: Promise<T>, successMsg: string | ((res: T) => string)): Promise<T> => (
  toastErrorIfAny(promise)
    .then((res) => {
      Notify.create({
        type: 'positive',
        message: typeof successMsg === 'function' ? successMsg(res) : successMsg,
      });
      return res;
    })
);
