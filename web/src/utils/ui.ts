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
    console.error(err);
    Notify.create({
      type: 'negative',
      message: getErrMsg(err.message),
    });
    return Promise.reject(err);
  });
