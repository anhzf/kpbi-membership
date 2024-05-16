export const sleep = (ms = 3000) => (
  new Promise<void>((resolve) => {
    setTimeout(() => {
      resolve();
    }, ms);
  })
);
