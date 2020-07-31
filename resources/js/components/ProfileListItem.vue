<template>
    <v-list-item>

        <v-list-item-avatar v-if="icon">
            <v-icon v-text="icon"></v-icon>
        </v-list-item-avatar>

        <v-list-item-content>
            <slot></slot>
        </v-list-item-content>

    </v-list-item>
</template>

<script>
export default {
    name: 'profile-list-item',
    props: {
        icon: {
            type: String,
            required: false,
        },
    }
}
</script>