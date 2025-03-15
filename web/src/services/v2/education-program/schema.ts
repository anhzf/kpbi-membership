import { CollegeSchema } from 'src/services/v2/college/schema';
import { AccreditableSchema, AccreditationSchema, TimestampsSchema } from 'src/services/v2/schema';
import { ACADEMIC_DEGREES } from 'src/types/constants';
import * as v from 'valibot';

export const AcademicDegreeSchema = v.picklist(ACADEMIC_DEGREES);

export const EducationProgramSchema = v.object({
  ...TimestampsSchema.entries,
  ...AccreditableSchema.entries,
  college: v.pick(CollegeSchema, [
    'id',
    'short_name',
    'name',
  ]),
  degree: AcademicDegreeSchema,
  img: v.nullish(v.string()),
  department: v.nullish(v.string()),
  faculty: v.nullish(v.string()),
  email: v.nullish(v.string()),
  phone_number: v.nullish(v.string()),
  external_link: v.nullish(v.string()),
  accreditations: v.array(v.pick(AccreditationSchema, [
    'id',
    'label',
    'value',
  ])),
});
