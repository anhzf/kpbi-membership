import { AxiosError, toFormData } from 'axios';
import { fromMembershipRaw, fromMembershipRequestRaw } from 'src/services/converter';
import type {
  GetMember, GetMemberList, MemberService, RegisterMember, ListRequestMembership, RequestMembership, UpdateCollege,
} from 'src/services/member/MemberService';
import type { MemberRaw, MembershipRequestRaw } from 'src/services/types';
import { api } from 'src/services/utils';

const ENDPOINT = '/member';
const MEMBERSHIP_ENDPOINT = '/membership';

let meId: string;

const get: GetMember = async (id) => {
  const { data } = await api.get<MemberRaw>(`${ENDPOINT}/${id}`);

  if (id === 'me') {
    meId = data.id;
  }

  return fromMembershipRaw(data);
};

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

const updateCollege: UpdateCollege = async (payload) => {
  if (!meId) throw new Error('cannot determine the member id.', { cause: 'meId is not set' });
  const fd = toFormData(payload);
  // Workaround for the PUT method
  // https://laracasts.com/discuss/channels/laravel/axios-returns-empty-array-on-put-request-with-formdata-to-laravel-api
  fd.append('_method', 'PUT');
  await api.post(`${ENDPOINT}/${meId}`, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
};

const memberService: MemberService = {
  get,
  list,
  register,
  request,
  listRequest,
  updateCollege,
};

export default memberService;

export * from './MemberService';
export * from './logics';
