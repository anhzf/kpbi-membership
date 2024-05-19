<script lang="ts" setup>
import { useIsMemberItself } from 'src/composables/use-member-profile';
import { accreditationDestroy, accreditationStore, accreditationUpdate } from 'src/services/accreditation';
import memberService from 'src/services/member';
import { MemberProfile } from 'src/types/models';
import { inferDiffs } from 'src/utils/object';
import { pageLoading, toastErrorIfAny } from 'src/utils/ui';
import { ref } from 'vue';
import type { Values as AccreditationFormValues } from './AccreditationForm.vue';
import AccreditationForm from './AccreditationForm.vue';
import AccreditationListItems from './AccreditationListItems.vue';
import ProgramFields from './ProgramFields.vue';

interface Props {
  data: MemberProfile['education_program'];
}

interface Emits {
  (ev: 'updated'): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const isMemberOwner = useIsMemberItself();

const elmFields = ref<typeof ProgramFields>();
const showForm = ref(false);
const showAccreditationForm = ref(false);
const accreditationFormValues = ref<Partial<AccreditationFormValues>>();

const onUpdateFormSubmit = async () => {
  const fields = inferDiffs(elmFields.value?.fields, props.data);

  await toastErrorIfAny(
    pageLoading(memberService.updateProgram(fields)),
  );

  emit('updated');
  showForm.value = false;
};

const onAccreditationFormSubmit = async (values: AccreditationFormValues) => {
  await toastErrorIfAny(
    pageLoading<unknown>(values.id ? accreditationUpdate(values)
      : accreditationStore({
        ...values,
        entity: 'program',
        entity_id: props.data.id,
      })),
  );

  emit('updated');
  showAccreditationForm.value = false;
};

const onAccreditationRequestDelete = async (id: string) => {
  await toastErrorIfAny(
    pageLoading(accreditationDestroy(id)),
  );

  emit('updated');
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
          v-if="isMemberOwner"
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
        <AccreditationListItems :data="data.accreditations" />

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

          <q-card-section>
            <q-list
              separator
              bordered
            >
              <q-item-label header>
                Akreditasi
              </q-item-label>

              <AccreditationListItems
                edit-mode
                :data="data.accreditations"
                @request-form="(showAccreditationForm = true, accreditationFormValues = $event)"
                @request-delete="onAccreditationRequestDelete($event)"
              />
            </q-list>
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

    <q-dialog
      v-model="showAccreditationForm"
      @hide="(accreditationFormValues = undefined)"
    >
      <q-card class="w-[55ch] max-w-90vw">
        <AccreditationForm
          :title="accreditationFormValues ? 'Perbarui Data Akreditasi' : 'Tambah Data Akreditasi'"
          :object-name="[accreditationFormValues?.label, data.name].filter(Boolean).join(' | ')"
          :data="accreditationFormValues"
          @submit="(onAccreditationFormSubmit($event))"
        />
      </q-card>
    </q-dialog>
  </q-card>
</template>
