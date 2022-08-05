import { UserDetails, UserLoginPayload } from 'src/repositories/user/model';

export interface UserRepository {
  get(): Promise<UserDetails | null>;
  login(payload: UserLoginPayload): Promise<UserDetails>;
  logout(): Promise<void>;
}
