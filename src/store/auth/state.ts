import type { Fb } from 'src/types';

export interface AuthStateInterface {
  user: Fb.User | null;
  isWaiting: boolean;
  isAdmin: boolean;
  afterLoginFn: (() => void) | null;
  afterLogoutFn: (() => void) | null;
}

export const state = (): AuthStateInterface => ({
  user: null,
  isAdmin: false,
  isWaiting: true,
  afterLoginFn: null,
  afterLogoutFn: null,
});

export default state;
