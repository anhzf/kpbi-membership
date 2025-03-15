import { EducationProgramSchema } from 'src/services/v2/education-program';
import { DateSchema, DefaultIdSchema } from 'src/services/v2/schema';
import * as v from 'valibot';

export const MembershipSchema = v.object({
  id: DefaultIdSchema,
  registration_id: v.nullish(v.string()),
  period_end: DateSchema,
  education_program: v.pick(EducationProgramSchema, [
    'id',
    'name',
  ]),
});
