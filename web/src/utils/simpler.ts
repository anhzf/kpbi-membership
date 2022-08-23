export const getErrMsg = (err: unknown, withCode = false) => {
  if (err instanceof Error) {
    return withCode
      ? `(${err.name}) ${err.message}`
      : err.message;
  }

  return String(err);
};
