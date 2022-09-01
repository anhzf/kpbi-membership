import { GUARD_TYPES } from 'src/constants';

export type GuardType = typeof GUARD_TYPES[number];

export interface _APIResponse<T = never> {
  message?: string;
  data?: T;
  [k: string]: unknown;
}

export type LooseDictionary = Record<string, unknown>;

export interface APIErrorTrace {
  class?: string;
  file?: string;
  function?: string;
  line?: string;
  type?: string;
}

export interface APIErrorResponse<T = never> extends _APIResponse<T> {
  exception: string;
  file: string;
  line: number;
  trace: APIErrorTrace[];
}

export interface APIValidationErrorResponse<T = never> extends _APIResponse<T> {
  errors: Record<string, string[]>;
}

export type APIResponse<T = never> = _APIResponse<T>
  | Partial<APIErrorResponse<T>>
  | Partial<APIValidationErrorResponse<T>>;

export const isAPIError = <T = never>(response: APIResponse<T>): response is APIErrorResponse<T> => response.exception !== undefined;

export const isAPIValidationError = <T = never>(response: APIResponse<T>): response is APIValidationErrorResponse<T> => response.errors !== undefined;
