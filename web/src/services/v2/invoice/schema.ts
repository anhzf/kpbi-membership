import { DateSchema, DefaultIdSchema, TimestampsSchema } from 'src/services/v2/schema';
import * as v from 'valibot';

export const InvoiceItemSchema = v.object({
  price: v.number(),
  qty: v.number(),
  desc: v.string(),
  ref: v.nullish(v.union([v.string(), v.number()])),
});

export const InvoiceSchema = v.object({
  ...TimestampsSchema.entries,
  id: DefaultIdSchema,
  receipt_to_id: DefaultIdSchema,
  receipt_to_type: v.string(),
  receipt_to_details: v.objectWithRest({
    name: v.string(),
  }, v.unknown()),
  items: v.record(v.string(), InvoiceItemSchema),
  due_at: DateSchema,
  paid_at: v.nullish(DateSchema),
  total: v.number(),
});
