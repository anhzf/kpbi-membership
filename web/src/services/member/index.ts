import { toFormData } from 'axios';
import { fromMembershipRaw, fromMembershipRequestRaw } from 'src/services/converter';
import type {
  GetMember, GetMemberList,
  ListMembershipRequestOfMember,
  ListRequestMembership,
  MemberService, MemberServiceBill, RegisterMember,
  RequestMembership, UpdateCollege,
  UpdateProgram,
} from 'src/services/member/MemberService';
import type { MemberRaw, MembershipRequestRaw } from 'src/services/types';
import { api } from 'src/services/utils';
import { omitByFilterValue } from 'src/utils/object';
import { shouldWait } from 'src/utils/promise';

const ENDPOINT = '/member';
const MEMBERSHIP_ENDPOINT = '/membership';

const states = {
  get meId(): string | null {
    return import.meta.hot?.data.meId ?? null;
  },
  set meId(value: string | null) {
    if (import.meta.hot) {
      import.meta.hot.data.meId = value;
    }
  },
};

const get: GetMember = async (id) => {
  const { data } = await api.get<MemberRaw>(`${ENDPOINT}/${id}`);

  if (id === 'me') {
    states.meId = data.id;
  }

  return fromMembershipRaw(data);
};

/* TODO: Reduce get() call */
const ensureMeId = shouldWait(async () => {
  if (!states.meId) {
    await get('me');
  }

  return states.meId!;
});

const list: GetMemberList = async () => {
  const { data } = await api.get(ENDPOINT);
  return data;
};

const register: RegisterMember = async (payload) => {
  await api.post(ENDPOINT, payload);
};

const request: RequestMembership = async (file) => {
  const formData = new FormData();
  formData.append('file', file);
  await api.post(MEMBERSHIP_ENDPOINT, formData);
};

const listRequest: ListRequestMembership = async () => {
  const { data } = await api.get<MembershipRequestRaw[]>(MEMBERSHIP_ENDPOINT);
  return data.map(fromMembershipRequestRaw);
};

const listRequestOf: ListMembershipRequestOfMember = async (id) => {
  const { data } = await api.get<MembershipRequestRaw[]>(`${MEMBERSHIP_ENDPOINT}/${id}/request`);
  return data.map((el) => fromMembershipRequestRaw(el));
};

const updateCollege: UpdateCollege = async (payload) => {
  if (!states.meId) throw new Error('cannot determine the member id.', { cause: 'meId is not set' });
  const fd = toFormData(omitByFilterValue(payload, (v) => !!v));
  // Workaround for the PUT method
  // https://laracasts.com/discuss/channels/laravel/axios-returns-empty-array-on-put-request-with-formdata-to-laravel-api
  fd.append('_method', 'PUT');
  fd.append('_entity', 'college');
  await api.post(`${ENDPOINT}/${states.meId}`, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
};

const updateProgram: UpdateProgram = async (payload) => {
  if (!states.meId) throw new Error('cannot determine the member id.', { cause: 'meId is not set' });
  const fd = toFormData(omitByFilterValue(payload, (v) => !!v));
  // Workaround for the PUT method
  // https://laracasts.com/discuss/channels/laravel/axios-returns-empty-array-on-put-request-with-formdata-to-laravel-api
  fd.append('_method', 'PUT');
  fd.append('_entity', 'program');
  await api.post(`${ENDPOINT}/${states.meId}`, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
};

export const memberServiceBill: MemberServiceBill = async () => {
  await api.post(`${ENDPOINT}/${await ensureMeId()}/bill`);
};

const memberService: MemberService = {
  get,
  list,
  register,
  request,
  listRequest,
  updateCollege,
  updateProgram,
  listRequestOf,
};

export default memberService;

export * from './MemberService';
export * from './logics';
