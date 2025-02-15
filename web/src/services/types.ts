import type {
  MemberProfile, EducationProgram, RelationExpanded, Accreditation, College, EducationProgramHead, User, MembershipRequest,
  Timestamps,
  Invoice,
  InvoiceDocumentPayload,
} from 'src/types/models';

export interface TimestampsRaw {
  created_at: string;
  updated_at: string;
}

export interface UserRaw extends Omit<User, 'created_at' | 'updated_at'> {
  created_at: string;
  updated_at: string;
}

export interface MemberRaw
  extends Omit<MemberProfile, 'education_program' | 'college' | 'responsible' | 'created_at' | 'updated_at'> {
  education_program: Omit<EducationProgram, 'accreditations'> & {
    accreditations: RelationExpanded<Accreditation>[];
    college: RelationExpanded<College>;
    heads: (Omit<EducationProgramHead, 'user' | 'program'> & { user: RelationExpanded<User> })[];
  };
  created_at: string;
  updated_at: string;
}

export interface MembershipRequestRaw
  extends Omit<MembershipRequest, 'created_at' | 'updated_at' | 'requested_date' | 'transfer_at' | 'valid_start' | 'valid_until'> {
  created_at: string;
  updated_at: string;
  requested_date: string;
  transfer_at: string | null;
  valid_start: string | null;
  valid_until: string | null;
}

export interface InvoiceRaw
  extends Omit<Invoice, keyof Timestamps | 'due_at' | 'paid_at'>, TimestampsRaw {
  due_at: string;
  paid_at?: string;
}

export interface InvoiceDocumentPayloadRaw
  extends Omit<InvoiceDocumentPayload, 'created_at' | 'due_at' | 'paid_at'> {
  created_at: string;
  due_at: string;
  paid_at?: string;
}
