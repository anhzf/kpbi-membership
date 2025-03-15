import { isAxiosError, type AxiosResponse } from 'axios';
import { ClientError } from 'src/services/ClientError';
import { isClientError } from 'src/services/utils';
import { ApiResponseErrorSchema } from 'src/services/v2/schema';
import * as v from 'valibot';

export const defineApi = <Fn extends (...args: any[]) => Promise<any>>(fn: Fn): Fn => {
  const intercepted = (async (...args: any[]) => {
    try {
      return await fn(...args);
    } catch (err) {
      if (isAxiosError(err)) {
        const { status, data } = err.response!;
        if (v.is(ApiResponseErrorSchema, data)) {
          if (isClientError(status)) {
            throw new ClientError(data.message, { cause: data.errors });
          }
          throw new Error(data.message, { cause: data.errors });
        }
      }

      throw err;
    }
  }) as Fn;

  return intercepted;
};

export const validatedResponse = (response: AxiosResponse) => {
  const { status, data } = response;
  if (v.is(ApiResponseErrorSchema, data)) {
    if (isClientError(status)) {
      throw new ClientError(data.message, { cause: data.errors });
    }
    throw new Error(data.message, { cause: data.errors });
  }
  return response;
};
