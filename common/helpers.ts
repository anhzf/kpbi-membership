// eslint-disable-next-line no-unused-vars
type anyFn = (...args: unknown[]) => unknown;

type attemptFn = () => boolean;

interface attemptOptions {
  maxTries: number;
  interval: number;
}

export const attempt = (
  fn: attemptFn,
  {
    maxTries,
    interval,
  }: attemptOptions,
) => {
  let tries = 0;

  return () => new Promise<void>((resolve, reject) => {
    const intervalId = setInterval(() => {
      if (tries >= maxTries) {
        clearInterval(intervalId);
        reject(`max invocation of ${fn.name || '[anonymousFn]'} exceeded!`);
      } else if (fn()) {
        resolve(clearInterval(intervalId));
      } else {
        tries += 1;
      }
    }, interval);
  });
};

export const once = (fn: anyFn) => {
  let isCalled = false;
  let firstCallResult: ReturnType<anyFn>;

  return (...args: unknown[]) => {
    if (!isCalled) {
      firstCallResult = fn(...args);
      isCalled = true;
    }

    return firstCallResult;
  };
};
