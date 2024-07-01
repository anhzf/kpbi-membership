import type { MembershipRequestStatus, UserRole } from 'src/types/constants';
import type { MembershipRequest, User } from 'src/types/models';

export interface MembershipRequestList {
  (status?: MembershipRequestStatus): Promise<MembershipRequest[]>;
}

interface MembershipRequestAcceptPayload {
  validStart: Date;
  validUntil: Date;
  registrationId?: string;
}

export interface MembershipRequestApprove {
  (id: string, payload?: MembershipRequestAcceptPayload): Promise<void>;
}

export interface ListUsers {
  (): Promise<User[]>;
}

export interface SetUserRole {
  (id: string, role?: UserRole): Promise<void>;
}

export interface AdminService {
  membershipRequestList: MembershipRequestList;
  membershipRequestApprove: MembershipRequestApprove;
}
