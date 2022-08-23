export interface RegisterPayload {
  name: string;
  email: string;
  password: string;
}

export interface Register {
  (payload: RegisterPayload): Promise<void>;
}

export interface UserService {
  register: Register;
}
