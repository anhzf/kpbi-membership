import { api } from 'src/boot/axios';
import type { AccreditationDestroy, AccreditationStore, AccreditationUpdate } from 'src/services/accreditation/AccreditationService';
import type { APIResponse } from 'src/types/common';

const ENDPOINT = '/accreditation';

export const accreditationStore: AccreditationStore = async (payload) => {
  const { data } = await api.post<APIResponse<string>>(ENDPOINT, payload);
  return data.data!;
};

export const accreditationUpdate: AccreditationUpdate = async ({ id, ...payload }) => {
  await api.put(`${ENDPOINT}/${id}`, payload);
};

export const accreditationDestroy: AccreditationDestroy = async (id) => {
  await api.delete(`${ENDPOINT}/${id}`);
};
