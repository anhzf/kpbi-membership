import { isAxiosError } from 'axios';

export const getErrMsg = (err: unknown, withCode = false) => {
  if (isAxiosError(err)) {
    return err.response?.data.message || err.message;
  }

  if (err instanceof Error) {
    return withCode
      ? `(${err.name}) ${err.message}`
      : err.message;
  }

  return String(err);
};
