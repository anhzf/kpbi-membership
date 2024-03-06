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

interface MembershipRequestRaw extends Omit<MembershipRequest, 'created_at' | 'updated_at' | 'requested_date'> {
  created_at: string;
  updated_at: string;
  requested_date: string;
}

const fromRaw = (raw: MemberRaw): MemberProfile => ({
  ...raw,
  college: raw.education_program.college,
  responsible: raw.education_program.heads.at(-1)!,
  period_end: new Date(raw.period_end),
  created_at: new Date(raw.created_at),
  updated_at: new Date(raw.updated_at),
});

const fromMembershipRequestRaw = (raw: MembershipRequestRaw): MembershipRequest => ({
  ...raw,
  created_at: new Date(raw.created_at),
  updated_at: new Date(raw.updated_at),
  requested_date: new Date(raw.requested_date),
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
