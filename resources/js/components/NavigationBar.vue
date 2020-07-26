<template>

    <v-app-bar app color="indigo" dark>
        <v-app-bar-nav-icon @click.stop="$emit('navigate')"></v-app-bar-nav-icon>
        <v-toolbar-title @click="$emit('authenticate')">KPBI</v-toolbar-title>
        <v-progress-linear indeterminate absolute bottom></v-progress-linear>
    </v-app-bar>

</template>

<script>
export default {
    name: 'NavigationBar'
}
</script>
