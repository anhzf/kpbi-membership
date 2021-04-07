<template>
  <v-alert
    v-show="show"
    dismissible close-icon="mdi-close"
    :type="type" :color="color" border="left" elevation="7"
    colored-border
  ><span v-html="message"></span>
  </v-alert>
</template>

<script>
export default {
  name: 'FlashMessage',
  inheritAttrs: false,
  props: {
    message: String,
    color: String,
    type: String,
    timeout: {
      type: Number,
      default: 1000 * 60
    }
  },
  data: () => ({
    show: true,
  }),
  mounted() {
    setTimeout(() => {
      this.show = false
    }, this.timeout);
  }
}
</script>
