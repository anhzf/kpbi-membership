import { ACADEMIC_DEGREES_LABELS, type AcademicDegree } from 'src/types/constants';
import type { Membership } from 'src/types/models';

interface GetMemberDisplayNameRequiredData {
  education_program: {
    degree: AcademicDegree;
    name: string;
  };
  college: {
    short_name: string;
    name: string;
  };
}

export const getMemberDisplayName = (member: GetMemberDisplayNameRequiredData, short = false) => [
  ACADEMIC_DEGREES_LABELS[member.education_program.degree],
  member.education_program.name,
  short ? member.college.short_name : member.college.name,
].join(' ');

export const isMemberVerified = (member: Membership) => member.period_end > new Date();
