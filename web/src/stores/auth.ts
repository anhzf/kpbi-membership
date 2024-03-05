import { defineStore } from 'pinia';
import authService, { LoginPayload } from 'src/services/auth';
import { User } from 'src/types/models';

const service = authService;

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as User | null,
    isReady: false,
  }),
  actions: {
    async refresh() {
      try {
        this.isReady = false;
        this.user = await service.user();
      } finally {
        this.isReady = true;
      }
    },

    async login(payload: LoginPayload) {
      this.isReady = false;
      try {
        await service.login(payload);
        await this.refresh();
      } finally {
        this.isReady = true;
      }
    },

    async logout() {
      this.isReady = false;
      try {
        await service.logout();
        this.user = null;
      } finally {
        this.isReady = true;
      }
    },
  },
});
