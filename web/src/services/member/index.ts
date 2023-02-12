import {
  GetMember, GetMemberList, MemberService, RegisterMember,
} from 'src/services/member/MemberService';
import { api } from 'src/services/utils';
import {
  Accreditation,
  College, EducationProgram, EducationProgramHead, MemberProfile, RelationExpanded, User,
} from 'src/types/models';

const ENDPOINT = '/members';

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

const memberService: MemberService = {
  get,
  list,
  register,
};

export default memberService;

export * from './MemberService';
