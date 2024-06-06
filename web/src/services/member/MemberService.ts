/* TODO: Uses modular instead of in object services */
import type { AcademicDegree } from 'src/types/constants';
import type {
  College, EducationProgram, MemberInList, MemberProfile, MembershipRequest,
} from 'src/types/models';

export interface GetMember {
  (id: string): Promise<MemberProfile | undefined>;
}

export interface GetMemberListQuery {
  active?: boolean;
}

export interface GetMemberList {
  (q?: GetMemberListQuery): Promise<MemberInList[]>;
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

export interface RequestMembership {
  (file: File): Promise<void>;
}

export interface ListRequestMembership {
  (): Promise<MembershipRequest[]>;
}

export interface UpdateCollegePayload extends Partial<Omit<College, 'img' | 'img_url' | 'accreditations'>> {
  img?: File;
}

export interface UpdateCollege {
  (payload: UpdateCollegePayload): Promise<void>;
}

export interface UpdateProgramPayload extends Partial<Omit<EducationProgram, 'img' | 'img_url' | 'accreditations'>> {
  img?: File;
}

export interface UpdateProgram {
  (payload: UpdateProgramPayload): Promise<void>;
}

export interface ListMembershipRequestOfMember {
  (id: string): Promise<MembershipRequest[]>;
}

export interface MemberServiceBill {
  (): Promise<void>;
}

export interface MemberService {
  get: GetMember;
  list: GetMemberList;
  register: RegisterMember;
  request: RequestMembership;
  listRequest: ListRequestMembership;
  updateCollege: UpdateCollege;
  updateProgram: UpdateProgram;
  listRequestOf: ListMembershipRequestOfMember;
}
