/* eslint-disable camelcase */
import axios from 'axios';
import type {LegacyProfile} from '../../../common/legacy';
import type {LegacyUser} from './types';

export const api = axios.create({
  baseURL: 'https://anggota.kpbi.or.id/api/',
  headers: {
    common: {
      'Content-Type': 'application/json',
    },
  },
});

export const setAuthorization = (type: string, token: string) => {
  api.defaults.headers.common.Authorization = `${type} ${token}`;
};

export interface LoginPayload {
  name: string;
  password: string;
}

export interface ApiLoginResponse {
  success: boolean;
  access_token: string;
  expires_at: string;
  token_type: 'Bearer';
}

export const login = (payload: LoginPayload) => api.post<ApiLoginResponse>('auth/login', payload);

export const getAuthenticatedUser = () => api.get<LegacyUser | null>('auth/user');

export const getAuthenticatedUserProfile = () => api.get<LegacyProfile>('kpbi/profile');
