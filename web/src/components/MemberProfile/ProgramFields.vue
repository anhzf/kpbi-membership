<script lang="ts" setup>
import { MemberProfile } from 'src/types/models';
import { ref } from 'vue';

interface Props {
  data?: MemberProfile['education_program'];
}

const props = defineProps<Props>();

const fields = ref({
  name: props.data?.name || '',
  email: props.data?.email || '',
  phone_number: props.data?.phone_number || '',
  external_link: props.data?.external_link || '',
  faculty: props.data?.faculty || '',
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
    v-model="fields.email"
    label="Email Kantor"
    outlined
    type="email"
  />
  <q-input
    v-model="fields.phone_number"
    label="Nomor Telpon Kantor"
    outlined
    type="tel"
  />
  <q-input
    v-model="fields.external_link"
    label="Website"
    outlined
    type="url"
  />
  <q-input
    v-model="fields.faculty"
    label="Fakultas"
    outlined
  />
</template>
