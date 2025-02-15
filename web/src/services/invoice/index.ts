import { api } from 'src/boot/axios';
import { fromInvoiceDocumentPayloadRaw, fromInvoiceRaw } from 'src/services/converter';
import type { InvoiceGet, InvoiceGetDocumentPayload, InvoiceList } from 'src/services/invoice/InvoiceService';
import memberService from 'src/services/member';
import type { InvoiceDocumentPayloadRaw, InvoiceRaw } from 'src/services/types';

const ENDPOINT = '/invoice';

export const invoiceGet: InvoiceGet = async (id) => {
  const { data } = await api.get<InvoiceRaw>(`${ENDPOINT}/${id}`);
  return fromInvoiceRaw(data);
};

export const invoiceList: InvoiceList = async () => {
  const { data: { data } } = await api.get<{ data: InvoiceRaw[] }>(ENDPOINT, {
    params: {
      membership: (await memberService.get('me'))?.id,
    },
  });
  return data.map(fromInvoiceRaw);
};

export const invoiceGetDocumentPayload: InvoiceGetDocumentPayload = async (id) => {
  const { data: { data } } = await api.get<{ data: InvoiceDocumentPayloadRaw }>(`${ENDPOINT}/${id}/document/payload`);
  return fromInvoiceDocumentPayloadRaw(data);
};
