/* eslint-disable class-methods-use-this */
import { api } from 'boot/axios';
import {
  UserDetails, UserDetailsRaw, UserLoginPayload,
} from 'src/repositories/user/model';
import { UserRepository } from 'src/repositories/user/repository';
import { APIDataResponse } from 'src/types/api';

const fromRaw = (raw: UserDetailsRaw): UserDetails => ({
  ...raw,
  created_at: new Date(raw.created_at),
  updated_at: new Date(raw.updated_at),
});

export class UserAPIRepository implements UserRepository {
  async get(): Promise<UserDetails | null> {
    const ENDPOINT = '/api/iam';
    const { data } = await api.get<APIDataResponse<UserDetailsRaw>>(ENDPOINT);
    return fromRaw(data.data);
  }

  async login(payload: UserLoginPayload): Promise<UserDetails> {
    const ENDPOINT = '/api/auth/login';
    const { data } = await api.post<APIDataResponse<{ cred: UserDetailsRaw }>>(ENDPOINT, payload);
    return fromRaw(data.data.cred);
  }

  async logout(): Promise<void> {
    const ENDPOINT = '/api/iam';
    await api.delete(ENDPOINT);
  }
}
