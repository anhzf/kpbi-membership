import { Course } from 'src/types/models';

export interface GetCourse {
  (id: string): Promise<Course>;
}

export interface ListCourse {
  (programId: string): Promise<Course[]>;
}

export interface CreateCoursePayload
  extends Omit<Course, 'id' | 'education_program' | 'created_at' | 'updated_at'> {
  education_program_id: string;
}

export interface CreateCourse {
  (payload: CreateCoursePayload): Promise<void>;
}

export interface UpdateCoursePayload
  extends Partial<CreateCoursePayload> {
  id: string;
}

export interface UpdateCourse {
  (payload: UpdateCoursePayload): Promise<void>;
}

export interface DeleteCourse {
  (id: string): Promise<void>;
}

export interface CourseService {
  get: GetCourse;
  list: ListCourse;
  create: CreateCourse;
  update: UpdateCourse;
  delete: DeleteCourse;
}
