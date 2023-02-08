export const ACCREDITATION_STATUSES = ['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'] as const;

export type AccreditationStatus = typeof ACCREDITATION_STATUSES[number];

export const ACADEMIC_DEGREES = ['bachelor', 'master', 'doctor'] as const;

export type AcademicDegree = typeof ACADEMIC_DEGREES[number];

export const ACADEMIC_DEGREES_LABELS = <Record<AcademicDegree, string>>{
  bachelor: 'S1',
  master: 'S2',
  doctor: 'S3',
};

export const COLLEGE_TYPES = ['state', 'private'] as const;

export type CollegeType = typeof COLLEGE_TYPES[number];

export const COLLEGE_TYPES_LABELS = <Record<CollegeType, string>>{
  state: 'Negeri',
  private: 'Swasta',
};

export const MEMBERSHIP_REQUEST_STATUSES = ['approved', 'rejected', 'pending'] as const;

export type MembershipRequestStatus = typeof MEMBERSHIP_REQUEST_STATUSES[number];

export const EDUCATION_PROGRAM_HEAD_STATUS = ['active', 'inactive'] as const;

export type EducationProgramHeadStatus = typeof EDUCATION_PROGRAM_HEAD_STATUS[number];

export const COURSE_SEMESTER_TYPES = ['odd', 'even'] as const;

export type CourseSemesterType = typeof COURSE_SEMESTER_TYPES[number];

export const COURSE_SEMESTER_TYPES_LABELS = <Record<CourseSemesterType, string>>{
  odd: 'Ganjil',
  even: 'Genap',
};
