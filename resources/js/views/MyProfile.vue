<template>
<v-container fluid>
    <v-row justify="center">

        <ProfileCard :editMode="editMode" id="10"></ProfileCard>

    </v-row>

    <v-tooltip top>
        <template v-slot:activator="{on, attrs}">
            <v-btn
                fab fixed bottom right
                color="blue" dark
                v-bind="attrs"
                v-on="on"
                @click="editMode ? save():editMode = true"
            >
                <v-icon v-if="editMode">mdi-content-save</v-icon>
                <v-icon v-else>mdi-pencil</v-icon>
            </v-btn>
        </template>
        <span v-if="editMode">Save</span>
        <span v-else>Edit</span>
    </v-tooltip>
    
</v-container>

</template>

<script>
import ProfileCard from "../components/ProfileCard";


export default {
    name: 'MyProfile',


    data() {
        return {
            editMode: true,
        }
    },


    methods: {
        save() {
            console.log('saved!')
            this.editMode = false
        }
    },


    components: {
        ProfileCard,
    }
}
</script>