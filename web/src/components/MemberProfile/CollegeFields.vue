<script lang="ts" setup>
import { CollegeType } from 'src/types/constants';
import { College } from 'src/types/models';
import { ref } from 'vue';

const TYPE_OPTIONS = Object.entries(<Record<CollegeType, string>>{
  state: 'Negeri',
  private: 'Swasta',
}).map(([value, label]) => ({
  label,
  value,
}));

interface Props {
  data?: College;
}

const props = defineProps<Props>();

const fields = ref({
  name: props.data?.name || '',
  _short_name: props.data?.name || '',
  get short_name() {
    return this._short_name;
  },
  set short_name(v) {
    this._short_name = v.toLocaleUpperCase();
  },
  type: props.data?.type || '',
  city: props.data?.city || '',
  province: props.data?.province || '',
  street_address: props.data?.street_address || '',
});

defineExpose({
  fields,
});
</script>

<template>
  <q-input
    v-model="fields.name"
    label="Nama"
    outlined
  />
  <q-input
    v-model="fields.short_name"
    label="Nama Singkat"
    outlined
  />
  <q-select
    v-model="fields.type"
    label="Tipe"
    outlined
    :options="TYPE_OPTIONS"
    emit-value
    map-options
  />
  <q-input
    v-model="fields.city"
    label="Kota"
    outlined
  />
  <q-input
    v-model="fields.province"
    label="Provinsi"
    outlined
  />
  <q-input
    v-model="fields.street_address"
    label="Alamat"
    outlined
    type="textarea"
  />
</template>
