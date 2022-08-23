import api from 'src/services/api';
import { User } from 'src/types/models';
import {
  AuthService, GetCurrentUser, Login, Logout,
} from './AuthService';

const ENDPOINT = '/auth';

interface UserRaw extends Omit<User, 'created_at' | 'updated_at'> {
  created_at: string;
  updated_at: string;
}

interface LoginPayload {
  email: string;
  password: string;
}

const fromRaw = (raw: UserRaw): User => ({
  ...raw,
  created_at: new Date(raw.created_at),
  updated_at: new Date(raw.updated_at),
});

const getUser: GetCurrentUser = async () => {
  const res = await api.get<UserRaw>(ENDPOINT);
  return fromRaw(res.data);
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
