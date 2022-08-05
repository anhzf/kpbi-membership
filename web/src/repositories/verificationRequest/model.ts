import { VERIFICATION_REQUEST_STATUS } from 'src/constants';

export type VerificationRequestStatus = typeof VERIFICATION_REQUEST_STATUS[number];

export interface VerificationRequest {
  userId: string;
  documentPath: string;
  requestedDate: Date;
  status: VerificationRequestStatus;
  message: string;
}
