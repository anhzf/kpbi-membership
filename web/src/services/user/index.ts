import axios from 'axios';
import { Notify } from 'quasar';
import { api } from 'src/services/utils';
import { APIResponse, isAPIValidationError } from 'src/types/common';
import { getErrMsg } from 'src/utils/simpler';
import { handleValidationError } from '../utils';
import {
  ChangePassword,
  ResetPassword, SendEmailVerificationRequest, SendResetPasswordRequest, UserService,
} from './UserService';

const ENDPOINT = '/user';

const sendResetPasswordRequest: SendResetPasswordRequest = async (payload) => {
  try {
    const { status, data } = await api.post<APIResponse>(`${ENDPOINT}/forgot`, payload, {
      params: {
        handler_url: `${window.location.origin}/reset-password`,
      },
    });

    if (status === 200 && data.message) {
      Notify.create({
        type: 'positive',
        message: data.message,
      });
    }
  } catch (err) {
    if (axios.isAxiosError(err)) {
      const resp = err.response?.data as APIResponse;

      if (isAPIValidationError(resp)) {
        handleValidationError(resp);
      }
    }

    Notify.create({
      type: 'negative',
      message: getErrMsg(err),
    });
  }
};

const resetPassword: ResetPassword = async (payload) => {
  try {
    const { status, data } = await api.post<APIResponse>(`${ENDPOINT}/reset-password`, payload);

    if (status === 200 && data.message) {
      Notify.create({
        type: 'positive',
        message: data.message,
      });
    }
  } catch (err) {
    if (axios.isAxiosError(err)) {
      const resp = err.response?.data as APIResponse;

      if (isAPIValidationError(resp)) {
        handleValidationError(resp);
      }
    }

    Notify.create({
      type: 'negative',
      message: getErrMsg(err),
    });
  }
};

const sendEmailVerificationRequest: SendEmailVerificationRequest = async () => {
  try {
    const { data } = await api.get<APIResponse>(`${ENDPOINT}/verify/resend`, {
      params: {
        handler_url: window.location.origin,
      },
    });

    if (data.message) {
      Notify.create({
        type: 'positive',
        message: data.message,
      });
    }
  } catch (err) {
    if (axios.isAxiosError(err)) {
      const resp = err.response?.data as APIResponse;

      if (isAPIValidationError(resp)) {
        handleValidationError(resp);
      }
    }

    Notify.create({
      type: 'negative',
      message: getErrMsg(err),
    });
  }
};

const changePassword: ChangePassword = async (payload) => {
  try {
    const { data } = await api.put<APIResponse>(`${ENDPOINT}/change-password`, payload);

    if (data.message) {
      Notify.create({
        type: 'positive',
        message: data.message,
      });
    }
  } catch (err) {
    if (axios.isAxiosError(err)) {
      const resp = err.response?.data as APIResponse;

      if (isAPIValidationError(resp)) {
        handleValidationError(resp);
      }
    }

    Notify.create({
      type: 'negative',
      message: getErrMsg(err),
    });
  }
};

const userService: UserService = {
  sendResetPasswordRequest,
  resetPassword,
  sendEmailVerificationRequest,
  changePassword,
};

export default userService;

export * from './UserService';
