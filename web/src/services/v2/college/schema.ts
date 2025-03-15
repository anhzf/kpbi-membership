import { AccreditableSchema, AccreditationSchema, TimestampsSchema } from 'src/services/v2/schema';
import { COLLEGE_TYPES } from 'src/types/constants';
import * as v from 'valibot';

export const CollegeTypeSchema = v.picklist(COLLEGE_TYPES);

export const CollegeSchema = v.object({
  ...TimestampsSchema.entries,
  ...AccreditableSchema.entries,
  short_name: v.string(),
  type: CollegeTypeSchema,
  img: v.nullish(v.string()),
  img_url: v.nullish(v.string()),
  city: v.string(),
  province: v.string(),
  street_address: v.string(),
  accreditations: v.array(v.pick(AccreditationSchema, [
    'id',
    'label',
    'value',
    'valid_from',
    'valid_until',
  ])),
});
