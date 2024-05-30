import { api } from 'src/boot/axios';
import { fromInvoiceRaw } from 'src/services/converter';
import type { InvoiceGet } from 'src/services/invoice/InvoiceService';
import type { InvoiceRaw } from 'src/services/types';

const ENDPOINT = '/invoice';

export const invoiceGet: InvoiceGet = async (id) => {
  const { data } = await api.get<InvoiceRaw>(`${ENDPOINT}/${id}`);
  return fromInvoiceRaw(data);
};
