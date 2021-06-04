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
          :editMode="editMode"
          :onUpdate="v => { val = v }"
          :type="type"
        >
          <q-input
            v-model="val"
            :label="label"
            :readonly="!editMode"
            :dense="dense"
            :type="type"
          >
            <template #append>
              <q-btn
                v-if="isLink"
                type="a"
                :href="isEmail ? `mailto:${val}` : val"
                :icon="isEmail ? 'send' : 'open_in_new'"
                flat
                round
                size="sm"
                color="blue-10"
                target="_blank"
                @click="openLink"
              />
            </template>
          </q-input>
        </slot>
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { date, Notify } from 'quasar';
import fbs from 'src/firebaseService';
import { getErrMsg } from 'src/helpers';

const formatDate = 'YYYY-MM-DD';
const vEmailInput = (() => {
  const el = document.createElement('input');
  el.type = 'email';
  return el;
})();
const validateEmail = (v: string) => {
  vEmailInput.value = v;
  return vEmailInput.checkValidity();
};

export default defineComponent({
  name: 'CardProfileItem',
  props: {
    label: {
      type: String,
      required: true,
    },
    modelValue: {
      type: [String, Number, fbs.firestore.Timestamp],
      required: true,
    },
    icon: {
      type: String,
      default: '',
    },
    editMode: {
      type: Boolean,
      default: false,
    },
    dense: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      default: 'text',
    },
  },
  emits: ['update:modelValue'],
  computed: {
    val: {
      get(): string {
        try {
          return this.modelValue instanceof fbs.firestore.Timestamp
            ? date.formatDate(this.modelValue.toDate(), formatDate)
            : String(this.modelValue);
        } catch (err) {
          Notify.create({ message: getErrMsg(err), type: 'negative' });
          return date.formatDate(new Date(), formatDate);
        }
      },
      set(v: string) {
        try {
          this.$emit('update:modelValue', this.modelValue instanceof fbs.firestore.Timestamp
            ? fbs.firestore.Timestamp.fromDate(new Date(v))
            : v);
        } catch (err) {
          Notify.create({ message: getErrMsg(err), type: 'negative' });
        }
      },
    },
    isLink(): boolean {
      try {
        return Boolean(new URL(this.val));
      } catch (err) {
        return this.isEmail;
      }
    },
    isEmail(): boolean {
      return validateEmail(this.val);
    },
  },
  methods: {
    openLink(e: MouseEvent) {
      if (e.isTrusted) {
        window.open(this.isEmail ? `mailto:${this.val}` : this.val, '_blank');
      }
    },
  },
});
</script>
