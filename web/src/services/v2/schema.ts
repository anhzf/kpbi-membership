import * as v from 'valibot';

export const ApiResponseDataSchema = v.object({
  message: v.nullish(v.string()),
  data: v.any(),
});

export const ApiResponseErrorSchema = v.object({
  message: v.string(),
  errors: v.array(v.any()),
});

export const DefaultIdSchema = v.union([v.string(), v.pipe(v.number(), v.transform(String))]);

export const DateSchema = v.union([
  v.date(),
  v.pipe(v.string(), v.transform((val) => new Date(val))),
]);

export const TimestampsSchema = v.object({
  created_at: DateSchema,
  updated_at: DateSchema,
});

export const AccreditableSchema = v.object({
  id: DefaultIdSchema,
  name: v.string(),
});

export const AccreditationSchema = v.object({
  id: DefaultIdSchema,
  label: v.string(),
  value: v.string(),
  accreditable: v.pick(AccreditableSchema, [
    'name',
  ]),
  valid_from: v.nullish(DateSchema),
  valid_until: v.nullish(DateSchema),
});
