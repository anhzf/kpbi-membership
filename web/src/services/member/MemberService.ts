import { AcademicDegree } from 'src/types/constants';
import { MemberInList, MemberProfile } from 'src/types/models';

export interface GetMember {
  (id: string): Promise<MemberProfile | undefined>;
}

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
  get: GetMember;
  list: GetMemberList;
  register: RegisterMember;
}
