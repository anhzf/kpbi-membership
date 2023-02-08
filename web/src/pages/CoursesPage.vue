<!-- TODO: Refactor component, Show actions only if authorized -->
<script lang="ts" setup>
import { useAsyncState, whenever } from '@vueuse/core';
import { Dialog, Notify, QForm } from 'quasar';
import useMemberProfile from 'src/composables/use-member-profile';
import courseServices from 'src/services/course';
import { COURSE_SEMESTER_TYPES_LABELS } from 'src/types/constants';
import { Course } from 'src/types/models';
import { requiredRule } from 'src/utils/input-rules';
import { getErrMsg } from 'src/utils/simpler';
import { reactive, ref } from 'vue';

const courseForm = ref<QForm>();
const _ui = reactive({
  showAddCourseDialog: false,
  isAddCourseDialogLoading: false,
});
const { state: profile, isLoading: isProfileLoading } = useMemberProfile();

const courseFormField = reactive<Partial<Course>>({
  id: undefined,
  name: '',
  code: '',
  credits: undefined,
  semester: undefined,
  info: {
    cpmk: '',
  },
  lecturer: '',
  description: '',
});

const { state: courses, execute: fetchCourses, isLoading: isCoursesLoading } = useAsyncState<Course[]>(
  () => courseServices.list(profile.value!.id),
  [],
  { immediate: false },
);

const onCourseFormDialogClose = () => {
  courseForm.value?.reset();
};

const onCloseCourseFormDialogClick = () => {
  _ui.showAddCourseDialog = false;
  onCourseFormDialogClose();
};

const onCourseFormSubmit = async () => {
  _ui.isAddCourseDialogLoading = true;

  try {
    const data = {
      ...JSON.parse(JSON.stringify(courseFormField)),
      education_program_id: profile.value!.education_program.id,
    };

    if (data.id) {
      await courseServices.update(data);
    } else {
      await courseServices.create(data);
    }

    _ui.showAddCourseDialog = false;
    fetchCourses();
    onCourseFormDialogClose();
  } catch (err) {
    Notify.create({
      message: getErrMsg(err),
      color: 'negative',
    });
  } finally {
    _ui.isAddCourseDialogLoading = false;
  }
};

const onUpdateCourseClick = (course: Course) => {
  courseFormField.id = course.id;
  courseFormField.name = course.name;
  courseFormField.code = course.code;
  courseFormField.credits = course.credits;
  courseFormField.semester = course.semester;
  courseFormField.info!.cpmk = course.info.cpmk;
  courseFormField.lecturer = course.lecturer;
  courseFormField.description = course.description;

  _ui.showAddCourseDialog = true;
};

const onDeleteCourseClick = async (course: Course) => {
  Dialog.create({
    title: 'Hapus Mata Kuliah',
    message: 'Apakah anda yakin ingin menghapus mata kuliah ini?',
    cancel: true,
    persistent: true,
  })
    .onOk(async () => {
      try {
        await courseServices.delete(course.id);
        fetchCourses();
      } catch (err) {
        Notify.create({
          message: getErrMsg(err),
          color: 'negative',
        });
      }
    });
};

whenever(() => profile.value?.id, () => {
  fetchCourses();
}, { immediate: true });
</script>

<template>
  <q-page
    padding
    class="column gap-6"
  >
    <div class="row justify-between">
      <q-btn
        icon="arrow_back"
        flat
        round
        @click="$router.back"
      />

      <q-btn
        label="Tambah Matkul"
        icon="add"
        @click="_ui.showAddCourseDialog = true"
      />
    </div>

    <div class="row q-col-gutter-md items-stretch">
      <template v-if="courses.length">
        <div
          v-for="course in courses"
          :key="course.id"
          class="col-3"
        >
          <q-card class="h-full column">
            <q-card-section class="q-pb-xs">
              <div class="text-h6">
                {{ course.name }}
              </div>
              <div>
                <span class="text-caption">Kode MK: </span>
                <span class="text-subtitle2">
                  {{ course.code }}
                </span>
              </div>
            </q-card-section>

            <q-card-section>
              <q-list>
                <q-item>
                  <q-item-section>
                    <q-item-label>Jumlah SKS</q-item-label>
                    <q-item-label caption>
                      {{ course.credits }}
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label>Semester</q-item-label>
                    <q-item-label caption>
                      {{ COURSE_SEMESTER_TYPES_LABELS[course.semester] }}
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label>CPMK</q-item-label>
                    <q-item-label caption>
                      {{ course.info.cpmk }}
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label>Dosen Pengampu</q-item-label>
                    <q-item-label caption>
                      {{ course.lecturer }}
                    </q-item-label>
                  </q-item-section>
                </q-item>

                <q-item>
                  <q-item-section>
                    <q-item-label>Deskripsi</q-item-label>
                    <q-item-label caption>
                      {{ course.description }}
                    </q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-card-section>

            <q-space />
            <q-separator />

            <q-card-actions class="no-wrap">
              <q-btn
                label="Hapus"
                icon="delete"
                color="negative"
                outline
                class="w-full"
                @click="onDeleteCourseClick(course)"
              />
              <q-btn
                label="Perbarui"
                icon="edit"
                color="secondary"
                outline
                class="w-full"
                @click="onUpdateCourseClick(course)"
              />
            </q-card-actions>
          </q-card>
        </div>
      </template>

      <template v-else>
        <div class="col-12">
          <p class="text-center">
            Belum ada mata kuliah
          </p>
        </div>
      </template>
    </div>

    <q-inner-loading :showing="isProfileLoading || isCoursesLoading" />
  </q-page>

  <q-dialog
    v-model="_ui.showAddCourseDialog"
    persistent
  >
    <q-card class="w-full max-w-screen-sm">
      <q-form
        ref="courseForm"
        :method="courseFormField.id ? 'PUT' : 'POST'"
        @submit="onCourseFormSubmit"
      >
        <q-card-section>
          <div class="text-h6">
            Tambah Mata Kuliah MBKM
          </div>
        </q-card-section>

        <q-card-section>
          <q-select
            v-model="courseFormField.semester"
            label="Semester"
            filled
            :options="Object.entries(COURSE_SEMESTER_TYPES_LABELS).map(([key, value]) => ({ label: value, value: key }))"
            emit-value
            map-options
            autofocus
            :rules="[requiredRule]"
          />
        </q-card-section>

        <q-separator />

        <q-slide-transition>
          <q-card-section
            v-show="courseFormField.semester"
          >
            <q-input
              v-model="courseFormField.name"
              label="Nama Mata Kuliah"
              outlined
              :disable="!courseFormField.semester"
              :rules="[requiredRule]"
            />

            <q-input
              v-model="courseFormField.code"
              label="Kode Mata Kuliah"
              outlined
              :disable="!courseFormField.semester"
              :rules="[requiredRule]"
            />

            <q-input
              v-model="courseFormField.credits"
              label="Beban SKS"
              type="number"
              outlined
              :disable="!courseFormField.semester"
              :rules="[requiredRule]"
            />

            <q-input
              v-model="courseFormField.description"
              label="Deskripsi Mata Kuliah"
              type="textarea"
              outlined
              :disable="!courseFormField.semester"
              :rules="[requiredRule]"
            />

            <q-input
              v-model="courseFormField.info!.cpmk"
              type="textarea"
              label="CPMK"
              outlined
              :disable="!courseFormField.semester"
              :rules="[requiredRule]"
            />

            <q-input
              v-model="courseFormField.lecturer"
              label="Dosen Pengampu"
              outlined
              :disable="!courseFormField.semester"
              :rules="[requiredRule]"
            />
          </q-card-section>
        </q-slide-transition>

        <q-card-actions align="right">
          <q-btn
            flat
            label="Batalkan"
            color="negative"
            @click="onCloseCourseFormDialogClick"
          />
          <q-btn
            label="Simpan"
            type="submit"
            color="primary"
          />
        </q-card-actions>

        <q-inner-loading :showing="_ui.isAddCourseDialogLoading" />
      </q-form>
    </q-card>
  </q-dialog>
</template>
