import { api } from 'src/boot/axios';
import { validatedResponse } from 'src/services/v2/api';
import { InvoiceSchema } from 'src/services/v2/invoice';
import { MembershipSchema } from 'src/services/v2/membership/schema';
import { ApiResponseDataSchema } from 'src/services/v2/schema';
import * as v from 'valibot';

const ENDPOINT = '/v2/memberships';

export const get = async (id: string) => {
  const endpoint = `${ENDPOINT}/${id}`;
  const { data } = validatedResponse(await api.get(endpoint));

  return v.parse(
    MembershipSchema,
    v.is(ApiResponseDataSchema, data) ? data.data : data,
  );
};

export const invoicesOf = async (membershipId: string) => {
  const endpoint = `${ENDPOINT}/${membershipId}/invoices`;
  const { data } = validatedResponse(await api.get(endpoint));

  return v.parse(
    v.array(InvoiceSchema),
    v.is(ApiResponseDataSchema, data) ? data.data : data,
  );
};
