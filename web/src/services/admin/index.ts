import { api } from 'src/boot/axios';
import { fromMembershipRequestRaw, fromUserRaw } from 'src/services/converter';
import type { UserRaw } from 'src/services/types';
import type {
  AdminService, ListUsers, MembershipRequestApprove, MembershipRequestList,
  SetUserRole,
} from './AdminService';

const ENDPOINT = '/admin';
const ENDPOINT_MEMBERSHIP = `${ENDPOINT}/membership`;

const membershipRequestList: MembershipRequestList = async (status = 'pending') => {
  const { data } = await api.get(ENDPOINT_MEMBERSHIP, { params: { status } });
  return data.map(fromMembershipRequestRaw);
};

const membershipRequestApprove: MembershipRequestApprove = async (id, payload) => {
  await api.put(`${ENDPOINT_MEMBERSHIP}/${id}`, {
    valid_start: payload?.validStart || null,
    valid_until: payload?.validUntil || null,
    registration_id: payload?.registrationId,
    amount: payload?.amount,
  });
};

export const listUsers: ListUsers = async () => {
  const { data } = await api.get<UserRaw[]>(`${ENDPOINT}/user`);
  return data.map(fromUserRaw);
};

export const setUserRole: SetUserRole = async (id, role) => {
  await api.put(`${ENDPOINT}/user/${id}/role`, { role });
};

const adminService: AdminService = {
  membershipRequestList,
  membershipRequestApprove,
};

export default adminService;
