import api from 'src/services/api';
import { Register, RegisterPayload, UserService } from './UserService';

const ENDPOINT = '/users';

const register: Register = (payload) => api.post<RegisterPayload, void>(ENDPOINT, payload);

const userService: UserService = {
  register,
};

export default userService;

export * from './UserService';
