/**
 * @param ms default 3000
 * @param value value to resolve
 */
export const sleep = <T = void>(ms?: number, value?: T) => (
  new Promise<T>((resolve) => {
    setTimeout(() => {
      resolve(value as T);
    }, ms || 3000);
  })
);
