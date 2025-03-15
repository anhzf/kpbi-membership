import { MembershipSchema } from 'src/services/v2/membership';
import { DateSchema, TimestampsSchema } from 'src/services/v2/schema';
import { UserSchema } from 'src/services/v2/user';
import { MEMBERSHIP_REQUEST_STATUSES } from 'src/types/constants';
import * as v from 'valibot';

export const MembershipRequestStatusSchema = v.picklist(MEMBERSHIP_REQUEST_STATUSES);

export const MembershipRequestSchema = v.object({
  ...TimestampsSchema.entries,
  id: v.string(),
  membership: v.pick(MembershipSchema, [
    'id',
    'education_program',
  ]),
  user: v.pick(UserSchema, [
    'id',
    'name',
  ]),
  requested_date: DateSchema,
  transfer_at: v.nullish(DateSchema),
  status: MembershipRequestStatusSchema,
  authorized_by: v.pick(UserSchema, [
    'id',
    'name',
  ]),
  authorized_at: v.nullish(DateSchema),
  valid_start: v.nullish(DateSchema),
  valid_until: v.nullish(DateSchema),
  attachment_url: v.string(),
  amount: v.number(),
});
