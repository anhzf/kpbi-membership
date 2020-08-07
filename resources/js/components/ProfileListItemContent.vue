<template>
    <div>
        <v-list-item-subtitle>{{ label }}</v-list-item-subtitle>
    
        <v-skeleton-loader v-if="$store.state.isContentLoading" type="text"></v-skeleton-loader>
        
        <template v-else>
            <!-- Input fields -->
            <template v-if="editMode">
                <v-select
                    v-if="choices"
                    :items="choices"
                    :value="value"
                    @change="$emit('input', $event)"
                ></v-select>
                <v-text-field v-else :value="value" @input="$emit('input', $event)"></v-text-field>
            </template>

            <v-tooltip bottom v-else open-delay="300">
                <template v-slot:activator="{on, attrs}">
                    <v-list-item-title v-bind="attrs" v-on="on">{{ value }}</v-list-item-title>
                </template>
                <span>{{ value }}</span>
            </v-tooltip>
        </template>

    </div>
</template>

<script>
export default {
    name: 'profile-list-item-content',
    props: {
        editMode: {
            type: Boolean,
            default: false,
        },
        label: String,
        value: String,
        choices: {
            type: Array,
            required: false,
        }
    },
}
</script>