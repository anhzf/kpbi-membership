import { ACADEMIC_DEGREES, ACCREDITATION_STATUSES, COLLEGE_TYPES } from 'src/types/constants';

type HasId = { id: unknown };

export type Relation<T extends HasId, Fields extends Exclude<keyof T, 'id'>> = Pick<T, Fields | 'id'>;

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

export type AccreditationStatus = typeof ACCREDITATION_STATUSES[number];

export type AcademicDegree = typeof ACADEMIC_DEGREES[number];

export type CollegeType = typeof COLLEGE_TYPES[number];

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
  phoneNumber?: string;
  /** Can be a website, linkt.ree maybe? */
  externalLink?: string;
}

export interface EducationProgramHead {
  id: string;
  user: Relation<User, 'name'>;
  img?: string;
  period_start: Date;
  period_end: Date;
}

export interface Membership extends Timestamps {
  id: string;
  period_start: Date;
  period_end: Date;
  education_program: Relation<EducationProgram, 'name'>;
}

/**
 * MemberProfile is just union of all possible profile types.
 * The profile data are NOT stored in database.
 */
export interface MemberProfile {
  membership: RelationExpanded<Membership>;
  college: Omit<RelationExpanded<College>, keyof Timestamps>;
  education_program: Omit<RelationExpanded<EducationProgram>, keyof Timestamps>;
  education_program_head: RelationExpanded<EducationProgramHead> & {
    user: Omit<RelationExpanded<User>, keyof Timestamps>;
  };
}
