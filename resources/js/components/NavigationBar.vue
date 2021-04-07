<template>

  <v-app-bar app color="light-green lighten-1" dark>
    <v-app-bar-nav-icon @click.stop="$emit('navigate')"></v-app-bar-nav-icon>
    <v-toolbar-title>KPBI</v-toolbar-title>
    <v-progress-linear :indeterminate="contentLoading" height="5" color="teal lighten-5" absolute bottom></v-progress-linear>
  </v-app-bar>

</template>

<script>
export default {
  name: 'NavigationBar',

  props: {
    contentLoading: Boolean,
  }
}
</script>
