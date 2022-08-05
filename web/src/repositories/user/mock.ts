import { uid } from 'quasar';
import { UserDetails } from 'src/repositories/user/model';
import { UserRepository } from 'src/repositories/user/repository';

const fakeUser: UserDetails = {
  id: uid(),
  name: 'John Doe',
  email: 'admin@anggota.kpbi.or.id',
  username: 'admin',
  created_at: new Date(),
  updated_at: new Date(),
};

export class UserMockRepository implements UserRepository {
  constructor(
    private readonly resolveTimeout = 0,
  ) {
    //
  }

  get(): Promise<UserDetails> {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(fakeUser);
      }, this.resolveTimeout);
    });
  }

  login(): Promise<UserDetails> {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(fakeUser);
      }, this.resolveTimeout);
    });
  }

  logout(): Promise<void> {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve();
      }, this.resolveTimeout);
    });
  }
}
