export interface User {
  id: string;
  name: string;
}

export interface UserDetails extends User {
  email: string;
  username: string;
  created_at: Date;
  updated_at: Date;
}

export interface UserDetailsRaw extends Omit<UserDetails, 'created_at' | 'updated_at'> {
  created_at: string;
  updated_at: string;
}

export interface UserLoginPayload {
  email: string;
  password: string;
}
