<script lang="ts" setup>
import { useAsyncState, whenever } from '@vueuse/core';
import { Dialog, Notify, QForm } from 'quasar';
import CourseCard from 'src/components/CourseCard.vue';
import CourseForm from 'src/components/CourseForm.vue';
import useMemberProfile from 'src/composables/use-member-profile';
import courseServices from 'src/services/course';
import { getMemberDisplayName } from 'src/services/member';
import { Course } from 'src/types/models';
import { getWhatsAppLink } from 'src/utils/common';
import { getErrMsg } from 'src/utils/simpler';
import { computed, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const isOwner = computed(() => route.params.memberId === 'me');
const courseForm = ref<QForm>();
const _ui = reactive({
  showAddCourseDialog: false,
  isCourseFormDialogLoading: false,
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

const {
  state: courses, execute: fetchCourses, isLoading: isCoursesLoading, error: isCoursesError,
} = useAsyncState<Course[]>(
  () => {
    try {
      return courseServices.list(profile.value!.education_program.id);
    } catch (err) {
      Notify.create({ message: getErrMsg(err), color: 'negative' });
    }
    return Promise.resolve([]);
  },
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
  _ui.isCourseFormDialogLoading = true;

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
    _ui.isCourseFormDialogLoading = false;
  }
};

const onAddCourseClick = () => {
  courseFormField.id = undefined;

  _ui.showAddCourseDialog = true;
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
    <div class="row justify-between items-center">
      <div class="row items-center gap-4">
        <q-btn
          icon="arrow_back"
          flat
          round
          @click="$router.back"
        />

        <div
          v-if="profile"
          class="column"
        >
          <div class="text-h6 q-my-none">
            Matkul MBKM:
            {{ getMemberDisplayName({
              college: profile.college,
              education_program: profile.education_program,
            }) }}
          </div>
          <div
            v-if="profile.responsible.user.phone_number"
            class="text-subtitle1 text-blue-grey"
          >
            Hubungi Kaprodi untuk informasi lebih lanjut tentang Mata Kuliah
            (<a
              :href="getWhatsAppLink(profile.responsible.user.phone_number)"
              target="_blank"
              class="text-blue-8"
            >{{ profile.responsible.user.phone_number }}</a>).
          </div>
        </div>
      </div>

      <q-btn
        v-if="isOwner"
        label="Tambah Matkul"
        icon="add"
        @click="onAddCourseClick"
      />
    </div>

    <div class="row q-col-gutter-md items-stretch">
      <template v-if="courses.length">
        <div
          v-for="course in courses"
          :key="course.id"
          class="col-4"
        >
          <CourseCard
            :title="course.name"
            :description="course.description"
            :credits="course.credits"
            :semester="course.semester"
            :lecturer="course.lecturer"
            :cpmk="course.info.cpmk"
            :code="course.code"
            :capacity="course.capacity"
            @update-click="onUpdateCourseClick(course)"
            @delete-click="onDeleteCourseClick(course)"
          />
        </div>
      </template>

      <template v-else-if="isCoursesError">
        <div class="col-12">
          <p class="text-center text-negative">
            <q-icon name="warning" />
            Terjadi kesalahan dalam mengambil data.
          </p>
        </div>
      </template>

      <template v-else>
        <div class="col-12">
          <p class="text-center">
            Belum ada mata kuliah.
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
    <CourseForm
      :model-value="courseFormField"
      :is-loading="_ui.isCourseFormDialogLoading"
      @update:model-value="onCourseFormSubmit"
    >
      <q-separator />

      <q-card-actions>
        <!-- <q-btn
          label="Kosongkan"
          type="reset"
          flat
        /> -->

        <q-space />

        <q-btn
          label="Batalkan"
          flat
          color="negative"
          @click="onCloseCourseFormDialogClick"
        />
        <q-btn
          label="Simpan"
          type="submit"
          color="primary"
        />
      </q-card-actions>
    </CourseForm>
  </q-dialog>
</template>
