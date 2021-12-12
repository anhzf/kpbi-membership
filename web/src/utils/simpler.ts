// eslint-disable-next-line @typescript-eslint/no-explicit-any
export const getErrMsg = (err: any, withCode = false) => {
  if (err instanceof Error) {
    return withCode
      ? `(${err.name}) ${err.message}`
      : err.message;
  }

  return String(err);
};
