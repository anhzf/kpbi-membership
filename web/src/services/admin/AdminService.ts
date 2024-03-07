import type { MembershipRequest } from 'src/types/models';

export interface MembershipRequestList {
  (): Promise<MembershipRequest[]>;
}

export interface MembershipRequestApprove {
  /**
   * @param id - Membership request ID
   * @param validUntil - When not provided, the request is rejected
   */
  (id: string, validUntil?: Date): Promise<void>;
}

export interface AdminService {
  membershipRequestList: MembershipRequestList;
  membershipRequestApprove: MembershipRequestApprove;
}
