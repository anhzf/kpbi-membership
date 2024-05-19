import { api } from 'src/boot/axios';
import type { AccreditationStore } from 'src/services/accreditation/AccreditationService';
import type { APIResponse } from 'src/types/common';

const ENDPOINT = '/accreditation';

export const accreditationStore: AccreditationStore = async (payload) => {
  const { data } = await api.post<APIResponse<string>>(ENDPOINT, payload);
  return data.data!;
};
