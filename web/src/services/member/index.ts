import type {
  GetMember, GetMemberList, MemberService, RegisterMember, ListRequestMembership, RequestMembership,
} from 'src/services/member/MemberService';
import { api } from 'src/services/utils';
import type {
  Accreditation,
  College, EducationProgram, EducationProgramHead, MemberProfile, MembershipRequest, RelationExpanded, User,
} from 'src/types/models';
import { sleep } from 'src/utils/promise';

const ENDPOINT = '/member';
const MEMBERSHIP_ENDPOINT = '/membership';

interface MemberRaw extends Omit<MemberProfile, 'education_program' | 'college' | 'responsible' | 'created_at' | 'updated_at'> {
  education_program: Omit<EducationProgram, 'accreditations'> & {
    accreditations: RelationExpanded<Accreditation>[];
    college: RelationExpanded<College>;
    heads: (Omit<EducationProgramHead, 'user' | 'program'> & { user: RelationExpanded<User> })[];
  };
  created_at: string;
  updated_at: string;
}

const fromRaw = (raw: MemberRaw): MemberProfile => ({
  ...raw,
  college: raw.education_program.college,
  responsible: raw.education_program.heads.at(-1)!,
  period_end: new Date(raw.period_end),
  created_at: new Date(raw.created_at),
  updated_at: new Date(raw.updated_at),
});

const get: GetMember = async (id) => {
  const { data } = await api.get<MemberRaw>(`${ENDPOINT}/${id}`);
  return fromRaw(data);
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

// const { data } = await api.get(MEMBERSHIP_ENDPOINT);
// return data;
const listRequest: ListRequestMembership = async () => sleep<MembershipRequest[]>(1000, [
  {
    id: '1',
    user: { id: '3', name: 'John Doe' },
    membership: { id: '1', education_program: { id: '1', name: 'Computer Science' } },
    requested_date: new Date(Date.now() - 3600_000 * 24 * 7),
    status: 'pending',
    created_at: new Date(Date.now() - 3600_000 * 24 * 7),
    updated_at: new Date(Date.now() - 3600_000 * 24 * 7),
  },
]);
const memberService: MemberService = {
  get,
  list,
  register,
  request,
  listRequest,
};

export default memberService;

export * from './MemberService';
