export const requiredRule = (val: unknown) => !!val || 'Isian ini wajib diisi';

export const dateTimeRule = (val: unknown) => {
  try {
    return !!(new Date(String(val)));
  } catch (err) {
    return err instanceof Error ? err.message : String(err);
  }
};

export const urlRule = (v: unknown) => {
  try {
    return !!(new URL(String(v)));
  } catch (err) {
    if (err instanceof Error) {
      return err.message;
    }

    return String(err);
  }
};

export const shouldEq = (fieldName: string, match: string | (() => string)) => (
  (v: unknown) => (v === (typeof match === 'function' ? match() : match)) || `Harus sama dengan ${fieldName}`
);

export const minOrEq = (min: number) => (
  (v: unknown) => (Number(v) >= min) || `Harus minimal/sama dengan ${min}`
);
