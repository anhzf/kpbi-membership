import { api } from 'src/services/utils';
import {
  CourseService, CreateCourse, DeleteCourse, GetCourse, ListCourse, UpdateCourse,
} from './CourseService';

const ENDPOINT = '/course';

const get: GetCourse = async (id) => {
  const { data } = await api.get(`${ENDPOINT}/${id}`);
  return data;
};

const list: ListCourse = async (programId) => {
  const { data } = await api.get(ENDPOINT, { params: { program_id: programId } });
  return data;
};

const create: CreateCourse = async (payload) => {
  await api.post(ENDPOINT, payload);
};

const update: UpdateCourse = async ({ id, ...payload }) => {
  await api.put(`${ENDPOINT}/${id}`, payload);
};

const _delete: DeleteCourse = async (id) => {
  await api.delete(`${ENDPOINT}/${id}`);
};

const courseService: CourseService = {
  get,
  list,
  create,
  update,
  delete: _delete,
};

export default courseService;
export * from './CourseService';
