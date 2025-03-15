import { api } from 'src/boot/axios';
import { validatedResponse } from 'src/services/v2/api';
import { ApiResponseDataSchema } from 'src/services/v2/schema';
import * as v from 'valibot';
import { MembershipRequestState } from './schema';

export const getMembershipRequestStates = async () => {
  const endpoint = '/v2/admin/membership-requests-states';
  const { data } = validatedResponse(await api.get(endpoint));

  return v.parse(
    v.array(MembershipRequestState),
    v.is(ApiResponseDataSchema, data) ? data.data : data,
  );
};

export const attachMembershipRequestToInvoice = async (invoiceId: string, membershipRequestId: string) => {
  const endpoint = `/v2/admin/invoices/${invoiceId}/membership-request`;
  validatedResponse(await api.patch(endpoint, { id: membershipRequestId }));
};
