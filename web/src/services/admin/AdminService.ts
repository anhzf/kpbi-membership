import type { MembershipRequest } from 'src/types/models';

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

export interface AdminService {
  membershipRequestList: MembershipRequestList;
  membershipRequestApprove: MembershipRequestApprove;
}
