import type {
  AcademicDegree, AccreditationStatus, CollegeType, CourseSemesterType, EducationProgramHeadStatus, MembershipRequestStatus,
  UserRole,
} from 'src/types/constants';

export interface HasId {
  id: unknown;
}

/**
 * Pick all fields or picked (second type parameters) from T except 'id'.
 */
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
  phone_number?: string;
  img?: string;
  email_verified_at?: Date;
  role: UserRole | null;
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

export interface College extends Accreditable, Timestamps {
  short_name: string;
  type: CollegeType;
  img?: string;
  img_url?: string;
  city: string;
  province: string;
  street_address: string;
  accreditations: Relation<Accreditation, 'label' | 'value' | 'valid_from' | 'valid_until'>[];
}

export interface EducationProgram extends Accreditable, Timestamps {
  college: Relation<College, 'short_name' | 'name'>;
  degree: AcademicDegree;
  img?: string;
  department?: string;
  faculty?: string;
  email?: string;
  phone_number?: string;
  /** Can be a website, linkt.ree, whatever. */
  external_link?: string;
  // head: Relation<EducationProgramHead, 'user' | 'img'>;
  accreditations: Relation<Accreditation, 'label' | 'value'>[];
}

export interface EducationProgramHead extends Timestamps {
  id: string;
  user: Relation<User, 'name'>;
  program: Relation<EducationProgram, 'name'>;
  status: EducationProgramHeadStatus;
  period_start: Date;
  period_end: Date;
}

export interface Membership extends Timestamps {
  id: string;
  registration_id?: string;
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
  education_program: Omit<EducationProgram, 'college' | 'accreditations' | 'user'> & {
    accreditations: RelationExpanded<Accreditation>[];
  };
  college: College;
  responsible: Omit<EducationProgramHead, 'program' | 'user'> & { user: RelationExpanded<User>; };
}

export interface MemberInList {
  id: string;
  education_program: Relation<EducationProgram, 'name' | 'degree' | 'external_link' | 'college'>;
}

export interface MembershipRequest extends Timestamps {
  id: string;
  membership: Relation<Membership, 'education_program'>;
  user: Relation<User, 'name'>;
  requested_date: Date;
  transfer_at?: Date;
  status: MembershipRequestStatus;
  authorized_by?: Relation<User, 'name'>;
  authorized_at?: Date;
  valid_start?: Date;
  valid_until?: Date;
  attachment_url: string;
  amount?: number;
}

export interface Course extends Timestamps {
  id: string;
  education_program: Relation<EducationProgram, 'name'>;
  name: string;
  code: string;
  credits: number;
  description?: string;
  info: Record<string, any>;
  lecturer: string;
  capacity?: number;
  semester: CourseSemesterType;
}

export interface InvoiceItem {
  price: number;
  qty: number;
  desc: string;
}

export interface Invoice extends Timestamps {
  id: string;
  // receipt_to: {
  //   id: string;
  //   [k: string]: unknown;
  // };
  receipt_to_id: string;
  receipt_to_type: string;
  receipt_to_details: {
    name: string;
    [k: string]: unknown;
  };
  items: Record<string, InvoiceItem>;
  due_at: Date;
  paid_at?: Date;
}
