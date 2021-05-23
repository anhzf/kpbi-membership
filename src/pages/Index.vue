<template>
  <q-page
    padding
    class="cols"
  >
    <list-member />
  </q-page>
</template>

<script lang="ts">
import ListMember from 'src/components/ListTableMember.vue';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'PageIndex',
  components: { ListMember },
});
</script>
