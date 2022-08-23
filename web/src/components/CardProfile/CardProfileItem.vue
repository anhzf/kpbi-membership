<template>
  <q-item>
    <q-item-section
      v-if="icon"
      avatar
    >
      <q-icon :name="icon" />
    </q-item-section>

    <q-item-section>
      <q-item-label>
        <slot
          :value="val"
          :label="label"
          :edit-mode="editMode"
          :on-update="(v: string) => { val = v }"
          :type="type"
        >
          <q-input
            v-model="val"
            :label="label"
            :readonly="!editMode"
            :dense="dense"
            :type="type"
            v-bind="inputBind"
          >
            <template
              v-if="!editMode && isLink"
              #append
            >
              <q-btn
                type="a"
                :href="isEmail ? `mailto:${val}` : val"
                :icon="isEmail ? 'send' : 'open_in_new'"
                flat
                round
                size="sm"
                color="blue-10"
                target="_blank"
              />
            </template>
          </q-input>
        </slot>
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script lang="ts" setup>
import {
  defineProps, withDefaults, defineEmits, computed, defineExpose,
} from 'vue';
import { Notify, date } from 'quasar';
import { getErrMsg } from 'src/utils/simpler';
import type { QInputProps } from 'quasar';
import type { LooseDictionary } from 'src/types/common';

const DATE_FORMAT = 'YYYY-MM-DD';
// eslint-disable-next-line max-len
const EMAIL_REGEX = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
// eslint-disable-next-line max-len
const URL_REGEX = /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;

interface Props {
  label: string;
  modelValue: string | number | Date;
  icon?: string;
  editMode?: boolean;
  dense?: boolean;
  type?: QInputProps['type'];
  inputBind?: LooseDictionary;
}

const props = withDefaults(defineProps<Props>(), {
  icon: '',
  editMode: false,
  dense: false,
  type: 'text',
  inputBind: () => ({}),
});

const emits = defineEmits([
  'update:modelValue',
]);

const val = computed({
  get(): string {
    try {
      return props.modelValue instanceof Date
        ? date.formatDate(props.modelValue, DATE_FORMAT)
        : String(props.modelValue);
    } catch (err) {
      Notify.create({ message: getErrMsg(err), type: 'negative' });
      return date.formatDate(new Date(), DATE_FORMAT);
    }
  },
  set(v: string) {
    try {
      emits('update:modelValue', props.modelValue instanceof Date
        ? new Date(v)
        : v);
    } catch (err) {
      Notify.create({ message: getErrMsg(err), type: 'negative' });
    }
  },
});
const isEmail = computed(() => EMAIL_REGEX.test(val.value));
const isLink = computed(() => URL_REGEX.test(val.value) || isEmail.value);

defineExpose({
  val, isEmail, isLink,
});
</script>
