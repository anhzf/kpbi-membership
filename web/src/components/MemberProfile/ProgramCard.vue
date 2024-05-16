<script lang="ts" setup>
import memberService from 'src/services/member';
import { MemberProfile } from 'src/types/models';
import { inferDiffs } from 'src/utils/object';
import { pageLoading, toastErrorIfAny } from 'src/utils/ui';
import { ref } from 'vue';
import ProgramFields from './ProgramFields.vue';

interface Props {
  data: MemberProfile['education_program'];
}

interface Emits {
  (ev: 'updated'): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const elmFields = ref<typeof ProgramFields>();
const showForm = ref(false);

const onUpdateFormSubmit = async () => {
  const fields = inferDiffs(elmFields.value?.fields, props.data);

  await toastErrorIfAny(
    pageLoading(memberService.updateProgram(fields)),
  );

  emit('updated');
  showForm.value = false;
};
</script>

<template>
  <q-card
    flat
    bordered
  >
    <q-card-section>
      <div class="flex justify-between items-center gap-2">
        <h3 class="text-h6 m-0">
          Program Pendidikan
        </h3>
        <q-btn
          icon="edit"
          color="grey"
          flat
          round
          @click="showForm = true"
        />
      </div>

      <q-list>
        <q-item-label header>
          Akreditasi
        </q-item-label>

        <q-item
          v-for="accreditation in data.accreditations"
          :key="accreditation.id"
        >
          <q-item-section>
            <q-item-label overline>
              {{ accreditation.label }}
            </q-item-label>
            <q-item-label>
              <span class="text-h6 m-0">
                {{ accreditation.value }}
              </span>
            </q-item-label>
          </q-item-section>
          <q-item-section
            side
            top
          >
            <q-item-label caption>
              {{ accreditation.valid_from?.toLocaleDateString() }}—
            </q-item-label>
            <q-item-label caption>
              {{ accreditation.valid_until?.toLocaleDateString() }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-separator />

        <q-item-label header>
          Kontak
        </q-item-label>
        <q-item>
          <q-item-section>
            <q-item-label caption>
              Email kantor
            </q-item-label>
            <q-item-label>
              <a
                :href="data.email && `mailto:${data.email}`"
                target="_blank"
              >
                {{ data.email || '-' }}
              </a>
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Nomor Telpon kantor
            </q-item-label>
            <q-item-label>{{ data.phone_number || '-' }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item>
          <q-item-section>
            <q-item-label caption>
              Website
            </q-item-label>
            <q-item-label>
              <a
                :href="data.external_link"
                target="_blank"
              >
                {{ data.external_link || '-' }}
              </a>
            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-card-section>

    <q-dialog
      v-model="showForm"
      persistent
    >
      <q-card class="w-prose max-w-90vw">
        <q-form @submit.prevent="onUpdateFormSubmit">
          <q-card-section>
            <div class="text-h6">
              Perbarui Program Pendidikan
            </div>
          </q-card-section>

          <q-card-section class="flex flex-col gap-2">
            <program-fields
              ref="elmFields"
              :data="data"
            />
          </q-card-section>

          <q-card-actions>
            <q-btn
              label="Batal"
              flat
              @click="showForm = false"
            />
            <q-space />
            <q-btn
              label="Simpan"
              color="primary"
              type="submit"
            />
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>
  </q-card>
</template>
