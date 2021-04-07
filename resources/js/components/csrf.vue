<template>
  <input type="hidden" name="_token" v-model="token">
</template>

<script>
export default {
  name: 'CSRF',

  data() {
    return {
      token: document.querySelector('meta[name=csrf-token]').content
    }
  }
}
</script>
