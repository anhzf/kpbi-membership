import { GetMemberList, MemberService, RegisterMember } from 'src/services/member/MemberService';
import { api } from 'src/services/utils';

const ENDPOINT = '/members';

const list: GetMemberList = async () => {
  const { data } = await api.get(ENDPOINT);
  return data;
};

const register: RegisterMember = async (payload) => {
  await api.post(ENDPOINT, payload);
};

const memberService: MemberService = {
  list,
  register,
};

export default memberService;

export * from './MemberService';
