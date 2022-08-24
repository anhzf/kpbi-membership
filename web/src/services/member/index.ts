import { GetMemberList, MemberService } from 'src/services/member/MemberService';
import { api } from 'src/services/utils';

const ENDPOINT = '/members';

const list: GetMemberList = async () => {
  const { data } = await api.get(ENDPOINT);
  return data;
};

const memberService: MemberService = {
  list,
};

export default memberService;

export * from './MemberService';
