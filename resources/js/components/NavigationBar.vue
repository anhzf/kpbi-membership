<template>

    <v-app-bar app color="indigo" dark>
        <v-app-bar-nav-icon @click.stop="$emit('navigate')"></v-app-bar-nav-icon>
        <v-toolbar-title>KPBI</v-toolbar-title>
    </v-app-bar>

</template>

<script>
export default {
    name: 'NavigationBar'
}
</script>
