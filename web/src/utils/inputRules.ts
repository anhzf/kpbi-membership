export const requiredRule = (val: unknown) => !!val || 'Isian ini wajib diisi';

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
