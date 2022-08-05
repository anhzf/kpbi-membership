import { defineStore } from 'pinia';
import { UserAPIRepository } from 'src/repositories/user/api';
import { UserDetails, UserLoginPayload } from 'src/repositories/user/model';
import { UserRepository } from 'src/repositories/user/repository';

const repository: UserRepository = new UserAPIRepository();

export const useAuthStore = defineStore('auth', {
  state: () => ({
    cred: <UserDetails | null>(null),
    isReady: false,
  }),
  getters: {
    isAuthenticated: (state) => state.isReady && (state.cred !== null),
  },
  actions: {
    async validate() {
      try {
        this.isReady = false;
        this.cred = await repository.get();
      } finally {
        this.isReady = true;
      }
    },
    async login(payload: UserLoginPayload) {
      try {
        this.isReady = false;
        this.cred = await repository.login(payload);
      } finally {
        this.isReady = true;
      }
    },
    async logout() {
      try {
        this.isReady = false;
        await repository.logout();
        this.cred = null;
      } finally {
        this.isReady = true;
      }
    },
  },
});
