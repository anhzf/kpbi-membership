import { api, isCookieReady } from 'src/boot/axios';
import { simpleGet } from 'src/utils/api';

interface InvoiceDocContactPerson {
  id: number;
  email: string;
  name: string;
  phone_number: string;
  employee_id?: string;
}

const preRequest = async () => {
  await isCookieReady;
};

export const getInvoiceDocContactPerson = async () => {
  await preRequest();
  return simpleGet<InvoiceDocContactPerson>('/v2/admin/system/invoice-doc-contact-person');
};

export const setInvoiceDocContactPerson = async (personId: number | null) => {
  await preRequest();
  await api.put('/v2/admin/system/invoice-doc-contact-person', { person_id: personId });
};

export const getInvoiceDocTreasurer = async () => {
  await preRequest();
  return simpleGet<InvoiceDocContactPerson>('/v2/admin/system/invoice-doc-treasurer');
};

export const setInvoiceDocTreasurer = async (personId: number | null) => {
  await preRequest();
  await api.put('/v2/admin/system/invoice-doc-treasurer', { person_id: personId });
};

export const getMembershipFee = async () => {
  await preRequest();
  return simpleGet<number>('/v2/admin/system/membership-fee');
};

export const setMembershipFee = async (amount: number) => {
  await preRequest();
  await api.put('/v2/admin/system/membership-fee', { amount });
};
