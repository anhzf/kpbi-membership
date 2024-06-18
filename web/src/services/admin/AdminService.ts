import type { UserRole } from 'src/types/constants';
import type { MembershipRequest, User } from 'src/types/models';

export interface MembershipRequestList {
  (): Promise<MembershipRequest[]>;
}

export interface MembershipRequestApprove {
  /**
   * @param id - Membership request ID
   * @param validUntil - When not provided, the request is rejected
   * @param registrationId - Custom ID (Old ID)
   */
  (id: string, validUntil?: Date, registrationId?: string): Promise<void>;
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
