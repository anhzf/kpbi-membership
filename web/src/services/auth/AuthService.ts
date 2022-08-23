import type { User } from 'src/types/models';

export interface LoginPayload {
  username: string;
  password: string;
}

export interface Login {
  (payload: LoginPayload): Promise<void>;
}

export interface Logout {
  (): Promise<void>;
}

export interface GetCurrentUser {
  (): Promise<User>;
}

export interface AuthService {
  login: Login;
  logout: Logout;
  user: GetCurrentUser;
}
