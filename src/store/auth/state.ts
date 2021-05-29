import type fb from 'firebase';

export interface AuthStateInterface {
  user: fb.User | null;
  isWaiting: boolean;
  afterLoginFn: (() => void) | null;
  afterLogoutFn: (() => void) | null;
}

export const state = (): AuthStateInterface => ({
  user: null,
  isWaiting: true,
  afterLoginFn: null,
  afterLogoutFn: null,
});

export default state;
