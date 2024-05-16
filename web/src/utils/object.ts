type OmitByValue<T, V> = {
  [K in keyof T as T[K] extends V ? never : K]: T[K];
};

// eslint-disable-next-line @typescript-eslint/ban-types
export const omitByValue = <T extends {}, V extends T[keyof T]>(obj: T, value: V) => Object.fromEntries(
  Object.entries(obj).filter(([, v]) => v !== value),
) as OmitByValue<T, V>;

// eslint-disable-next-line @typescript-eslint/ban-types
export const omitByFilterValue = <T extends {}>(obj: T, filter: (v: T[keyof T]) => boolean) => Object.fromEntries(
  Object.entries(obj).filter(([, v]) => filter(v as T[keyof T])),
);

/**
 * Infer the differences between two objects.
 */
export const inferDiffs = <T extends Record<string, unknown>>(a: T, b: T): Partial<T> => Object.fromEntries(
  Object.entries({ ...b, ...a }).filter(([k, v]) => v !== b[k]),
) as Partial<T>;
