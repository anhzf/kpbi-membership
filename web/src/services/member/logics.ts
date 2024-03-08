import { ACADEMIC_DEGREES_LABELS } from 'src/types/constants';
import type { EducationProgram, Membership, RelationExpanded } from 'src/types/models';

export const getMemberDisplayName = (member: Membership & { education_program: RelationExpanded<EducationProgram> }, short = false) => [
  ACADEMIC_DEGREES_LABELS[member.education_program.degree],
  member.education_program.name,
  short ? member.education_program.college.short_name : member.education_program.college.name,
].join(' ');

export const isMemberVerified = (member: Membership) => member.period_end > new Date();
