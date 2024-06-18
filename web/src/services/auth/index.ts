import { fromUserRaw } from 'src/services/converter';
import type { UserRaw } from 'src/services/types';
import { api } from 'src/services/utils';
import {
  AuthService, GetCurrentUser, Login, Logout,
} from './AuthService';

const ENDPOINT = '/auth';
interface LoginPayload {
  email: string;
  password: string;
}

const getUser: GetCurrentUser = async () => {
  const res = await api.get<UserRaw>(ENDPOINT);
  return fromUserRaw(res.data);
};

const login: Login = (payload) => api.post<LoginPayload, void>(ENDPOINT, {
  email: payload.username,
  password: payload.password,
});

const logout: Logout = () => api.delete(ENDPOINT);

const authService: AuthService = {
  user: getUser,
  login,
  logout,
};

export default authService;

export * from './AuthService';
