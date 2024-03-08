import type { MemberRaw, MembershipRequestRaw } from 'src/services/types';
import type {
  MemberProfile, MembershipRequest,
} from 'src/types/models';

export const fromMembershipRaw = (raw: MemberRaw): MemberProfile => ({
  ...raw,
  college: raw.education_program.college,
  responsible: raw.education_program.heads.at(-1)!,
  period_end: new Date(raw.period_end),
  created_at: new Date(raw.created_at),
  updated_at: new Date(raw.updated_at),
});

export const fromMembershipRequestRaw = (raw: MembershipRequestRaw): MembershipRequest => ({
  ...raw,
  created_at: new Date(raw.created_at),
  updated_at: new Date(raw.updated_at),
  requested_date: new Date(raw.requested_date),
  valid_until: raw.valid_until ? new Date(raw.valid_until) : undefined,
});
