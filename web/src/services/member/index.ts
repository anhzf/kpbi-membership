import { fromMembershipRaw, fromMembershipRequestRaw } from 'src/services/converter';
import type {
  GetMember, GetMemberList, MemberService, RegisterMember, ListRequestMembership, RequestMembership,
} from 'src/services/member/MemberService';
import type { MemberRaw, MembershipRequestRaw } from 'src/services/types';
import { api } from 'src/services/utils';

const ENDPOINT = '/member';
const MEMBERSHIP_ENDPOINT = '/membership';

const get: GetMember = async (id) => {
  const { data } = await api.get<MemberRaw>(`${ENDPOINT}/${id}`);
  return fromMembershipRaw(data);
};

const list: GetMemberList = async () => {
  const { data } = await api.get(ENDPOINT);
  return data;
};

const register: RegisterMember = async (payload) => {
  await api.post(ENDPOINT, payload);
};

const request: RequestMembership = async (file) => {
  const formData = new FormData();
  formData.append('file', file);
  await api.post(MEMBERSHIP_ENDPOINT, formData);
};

const listRequest: ListRequestMembership = async () => {
  const { data } = await api.get<MembershipRequestRaw[]>(MEMBERSHIP_ENDPOINT);
  return data.map(fromMembershipRequestRaw);
};

const memberService: MemberService = {
  get,
  list,
  register,
  request,
  listRequest,
};

export default memberService;

export * from './MemberService';
export * from './logics';
