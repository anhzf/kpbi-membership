import { PubSub } from 'app/utils/PubSub';
import type { User } from 'src/repositories/user/model';

interface DefaultState {
  state: 'Waiting';
}

interface AuthenticatedState {
  state: 'Authenticated';
  user: User;
}

interface UnauthenticatedState {
  state: 'Unauthenticated';
}

interface ErrorState {
  state: 'Waiting';
  error: Error;
}

type IPubSub = DefaultState | AuthenticatedState | UnauthenticatedState | ErrorState;

export const UserPubSub = new PubSub<IPubSub>({
  state: 'Waiting',
});

export const setUser = (user: User) => {
  UserPubSub.publish({
    state: 'Authenticated',
    user,
  });
};

export const unsetUser = () => {
  UserPubSub.publish({
    state: 'Unauthenticated',
  });
};
