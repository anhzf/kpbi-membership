import { Notify } from 'quasar';
import { api } from 'src/boot/axios';
import { APIValidationErrorResponse } from 'src/types/common';

const handleValidationError = <T = never>({ errors }: APIValidationErrorResponse<T>) => {
  Object.entries(errors).forEach(([k, errs]) => {
    errs.forEach((el) => {
      Notify.create({
        type: 'negative',
        message: `ValidationError(${k}): ${el}`,
      });
    });
  });
};

export {
  api,
  handleValidationError,
};
