import { api } from 'src/boot/axios';
import { fromMembershipRequestRaw } from 'src/services/converter';
import type { AdminService, MembershipRequestApprove, MembershipRequestList } from './AdminService';

const ENDPOINT = '/admin';
const ENDPOINT_MEMBERSHIP = `${ENDPOINT}/membership`;

const membershipRequestList: MembershipRequestList = async () => {
  const { data } = await api.get(ENDPOINT_MEMBERSHIP);
  return data.map(fromMembershipRequestRaw);
};

const membershipRequestApprove: MembershipRequestApprove = async (id, validUntil, registrationId) => {
  await api.put(`${ENDPOINT_MEMBERSHIP}/${id}`, {
    valid_until: validUntil || null,
    registration_id: registrationId,
  });
};

const adminService: AdminService = {
  membershipRequestList,
  membershipRequestApprove,
};

export default adminService;
