import { DefaultIdSchema } from 'src/services/v2/schema';
import * as v from 'valibot';

export const MembershipRequestState = v.object({
  id: DefaultIdSchema,
  invoice_id: v.nullish(DefaultIdSchema),
});
