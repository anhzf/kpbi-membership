export const sleep = (ms = 3000) => (
  new Promise<void>((resolve) => {
    setTimeout(() => {
      resolve();
    }, ms);
  })
);

export const shouldWait = <T>(fn: () => Promise<T>) => {
  let resolver: ((value: T) => void) | null = null;

  let result = new Promise<T>((res) => {
    resolver = res;
  });

  const wrapped = async () => {
    if (resolver) {
      return result;
    }

    result = new Promise<T>((res) => {
      resolver = res;
    });

    result.finally(() => {
      resolver = null;
    });

    resolver!(await fn());

    return result;
  };

  return wrapped;
};
