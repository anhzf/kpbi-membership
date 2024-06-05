import { api } from 'src/boot/axios';
import { fromInvoiceRaw } from 'src/services/converter';
import type { InvoiceGet, InvoiceList } from 'src/services/invoice/InvoiceService';
import memberService from 'src/services/member';
import type { InvoiceRaw } from 'src/services/types';

const ENDPOINT = '/invoice';

export const invoiceGet: InvoiceGet = async (id) => {
  const { data } = await api.get<InvoiceRaw>(`${ENDPOINT}/${id}`);
  return fromInvoiceRaw(data);
};

export const invoiceList: InvoiceList = async () => {
  const { data } = await api.get<InvoiceRaw[]>(ENDPOINT, {
    params: {
      membership: (await memberService.get('me'))?.id,
    },
  });
  return data.map(fromInvoiceRaw);
};
