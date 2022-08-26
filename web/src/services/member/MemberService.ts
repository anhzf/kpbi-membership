import { AcademicDegree } from 'src/types/constants';
import { MemberInList } from 'src/types/models';

export interface GetMemberList {
  (): Promise<MemberInList[]>;
}

export interface RegisterMemberPayload {
  degree: AcademicDegree,
  college_name: string;
  college_short_name: string;
  program_name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface RegisterMember {
  (payload: RegisterMemberPayload): Promise<void>;
}

export interface MemberService {
  list: GetMemberList;
  register: RegisterMember;
}
