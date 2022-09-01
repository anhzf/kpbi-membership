import axios from 'axios';
import { Notify } from 'quasar';
import { api } from 'src/services/utils';
import { APIResponse, isAPIValidationError } from 'src/types/common';
import { handleValidationError } from '../utils';
import { ResetPassword, SendResetPasswordRequest, UserService } from './UserService';

const ENDPOINT = '/users';

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
  }
};

const userService: UserService = {
  sendResetPasswordRequest,
  resetPassword,
};

export default userService;

export * from './UserService';
