import { defineStore } from 'pinia';
import { isCookieReady } from 'src/boot/axios';
import type { LoginPayload } from 'src/services/auth';
import authService from 'src/services/auth';
import type { User } from 'src/types/models';

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
        if (await isCookieReady) {
          this.user = await service.user();
        }
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
