import { api } from 'src/boot/axios';
import { isAPIError, isAPIValidationError, type APIResponse } from 'src/types/common';

/**
 * Wrapper for simple v2 GET requests.
 */
export const simpleGet = async <T>(url: string): Promise<T> => {
  const { data } = await api.get<APIResponse<T>>(url);

  if (isAPIError(data) || isAPIValidationError(data)) {
    throw new Error(data.message || 'API Error', { cause: data });
  }

  return data.data as T;
};
