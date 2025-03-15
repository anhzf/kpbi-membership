import { DateSchema, TimestampsSchema } from 'src/services/v2/schema';
import { USER_ROLES } from 'src/types/constants';
import * as v from 'valibot';

export const UserRoleSchema = v.picklist(USER_ROLES);

export const UserSchema = v.object({
  ...TimestampsSchema.entries,
  id: v.string(),
  name: v.string(),
  email: v.string(),
  phone_number: v.nullish(v.string()),
  img: v.nullish(v.string()),
  role: UserRoleSchema,
  email_verified_at: v.nullish(DateSchema),
});
