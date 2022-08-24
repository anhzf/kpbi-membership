import {
  AcademicDegree, AccreditationStatus, CollegeType, EducationProgramHeadStatus, MembershipRequestStatus,
} from 'src/types/constants';

type HasId = { id: unknown };

export type Relation<T extends HasId, Fields extends Exclude<keyof T, 'id'> = never> = Pick<T, Fields | 'id'>;

export type RelationExpanded<T extends HasId> = Relation<T, Exclude<keyof T, 'id'>>;

export interface Timestamps {
  created_at: Date;
  updated_at: Date;
}

/* eslint-disable @typescript-eslint/no-empty-interface */
export interface User extends Timestamps {
  id: string;
  name: string;
  email: string;
}

export interface UserInList extends Pick<User, 'id' | 'name'> { }

export interface Activity {
  user: Pick<User, 'id' | 'name'>;
  action?: string;
  resource_name?: string;
  labels?: Record<string, unknown>;
  created_at: Date;
}

export interface Accreditable {
  id: string;
  name: string;
}

export interface Accreditation extends Timestamps {
  id: string;
  label: string;
  value: AccreditationStatus;
  accreditable: Relation<Accreditable, 'name'>;
  valid_from?: Date;
  valid_until?: Date;
}

export interface Addresses {
  city: string;
  province: string;
  street_address: string;
}

export interface College extends Accreditable, Timestamps {
  short_name: string;
  type: CollegeType;
  img?: string;
  address: Addresses;
  accreditations: Relation<Accreditation, 'label' | 'value'>[];
}

export interface EducationProgram extends Accreditable, Timestamps {
  college: Relation<College, 'short_name' | 'name'>;
  degree: AcademicDegree;
  img?: string;
  department?: string;
  faculty?: string;
  email?: string;
  phone_number?: string;
  /** Can be a website, linkt.ree maybe? */
  external_link?: string;
  // head: Relation<EducationProgramHead, 'user' | 'img'>;
  accreditations: Relation<Accreditation, 'label' | 'value'>[];
}

export interface EducationProgramHead {
  id: string;
  user: Relation<User, 'name'>;
  program: Relation<EducationProgram, 'name'>;
  status: EducationProgramHeadStatus;
  img?: string;
  period_start: Date;
  period_end: Date;
}

export interface Membership extends Timestamps {
  id: string;
  period_end: Date;
  education_program: Relation<EducationProgram, 'name'>;
}

// /**
//  * MemberProfile is just union of all possible profile types.
//  * The entire profile data are NOT stored in database.
//  */
// export interface MemberProfile {
//   membership: RelationExpanded<Membership>;
//   college: Omit<RelationExpanded<College>, keyof Timestamps>;
//   education_program: Omit<RelationExpanded<EducationProgram>, keyof Timestamps>;
//   education_program_head: RelationExpanded<EducationProgramHead> & {
//     user: Omit<RelationExpanded<User>, keyof Timestamps>;
//   };
// }

export type MemberProfile = Membership & {
  education_program: Omit<EducationProgram, 'college'>;
  college: College;
  responsible: Omit<EducationProgramHead, 'program'>;
}

export interface MemberInList {
  id: string;
  degree: AcademicDegree;
  education_program: Relation<EducationProgram, 'name' | 'external_link'>;
  college: Relation<College, 'name'>;
}

export interface MembershipRequest extends Timestamps {
  id: string;
  membership: Relation<Membership, 'education_program'>;
  user: Relation<User, 'name'>;
  requested_date: Date;
  status: MembershipRequestStatus;
  authorized_by?: Relation<User, 'name'>;
  authorized_at?: Date;
  valid_until?: Date;
}
