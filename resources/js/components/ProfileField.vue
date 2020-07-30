<template>
    <div>
        <v-list-item-subtitle>{{ item.label }}</v-list-item-subtitle>
    
        <!-- Input fields -->
        <template v-if="editMode">
            <v-select
                v-if="'choices' in item"
                :items="item.choices"
                v-model="item.value"
            ></v-select>
            <v-text-field v-else v-model="item.value"></v-text-field>

        <v-list-item-title v-else>{{ item.value }}</v-list-item-title>
        </template>

    </div>
</template>

<script>
export default {
    name: 'ProfileField',

    props: {
        editMode: Boolean,
        item: Object
    },
}
</script>