import type {
  MemberProfile, EducationProgram, RelationExpanded, Accreditation, College, EducationProgramHead, User, MembershipRequest,
} from 'src/types/models';

export interface MemberRaw extends Omit<MemberProfile, 'education_program' | 'college' | 'responsible' | 'created_at' | 'updated_at'> {
  education_program: Omit<EducationProgram, 'accreditations'> & {
    accreditations: RelationExpanded<Accreditation>[];
    college: RelationExpanded<College>;
    heads: (Omit<EducationProgramHead, 'user' | 'program'> & { user: RelationExpanded<User> })[];
  };
  created_at: string;
  updated_at: string;
}

export interface MembershipRequestRaw extends Omit<MembershipRequest, 'created_at' | 'updated_at' | 'requested_date'> {
  created_at: string;
  updated_at: string;
  requested_date: string;
}
