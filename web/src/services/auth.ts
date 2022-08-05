import { setUser, unsetUser } from 'src/pubsub/User';
import { UserMockRepository } from 'src/repositories/user/mock';
import { UserRepository } from 'src/repositories/user/repository';

const repository: UserRepository = new UserMockRepository();

export const authService = {
  async validate() {
    const user = await repository.get();

    if (user) setUser(user);
    else unsetUser();
  },

  async logout() {
    await repository.logout();
    unsetUser();
  },
};
