export interface SendResetPasswordRequestPayload {
  email: string;
}

export interface SendResetPasswordRequest {
  (payload: SendResetPasswordRequestPayload): Promise<void>;
}

export interface ResetPasswordPayload {
  token: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface ResetPassword {
  (payload: ResetPasswordPayload): Promise<void>;
}

export interface SendEmailVerificationRequest {
  (): Promise<void>;
}

export interface ChangePasswordPayload {
  current_password: string;
  password: string;
  password_confirmation: string;
}

export interface ChangePassword {
  (payload: ChangePasswordPayload): Promise<void>;
}

export interface UserService {
  sendResetPasswordRequest: SendResetPasswordRequest;
  resetPassword: ResetPassword;
  sendEmailVerificationRequest: SendEmailVerificationRequest;
  changePassword: ChangePassword;
}
