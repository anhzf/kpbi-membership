import type fb from 'firebase';

export interface AuthStateInterface {
  user: fb.User | null;
  isWaiting: boolean;
}

export const state = (): AuthStateInterface => ({
  user: null,
  isWaiting: true,
});

export default state;
