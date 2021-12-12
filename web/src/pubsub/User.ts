import { PubSub } from 'app/utils/PubSub';

interface User {
  id: string;
  name: string;
}

type State = 'Waiting' | 'Authenticated' | 'Unauthenticated';

interface IPubSub {
  state: State;
  user: User | null;
  error: Error | null;
}

export const UserPubSub = new PubSub<IPubSub>({
  state: 'Waiting',
  user: null,
  error: null,
});

export const setUser = (user: User) => {
  UserPubSub.publish({
    state: 'Authenticated',
    user,
    error: null,
  });
};

export const unsetUser = () => {
  UserPubSub.publish({
    state: 'Unauthenticated',
    user: null,
    error: null,
  });
};
