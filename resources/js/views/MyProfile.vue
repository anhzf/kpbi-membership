<template>
<v-container fluid>
    <v-row justify="center">

        <ProfileCard></ProfileCard>

    </v-row>

    <v-tooltip top>
        <template v-slot:activator="{on, attrs}">
            <v-btn
                fab fixed bottom right
                color="blue" dark
                v-bind="attrs"
                v-on="on"
            >
                <v-icon>mdi-content-save</v-icon>
            </v-btn>
        </template>
        <span>Save</span>
    </v-tooltip>
    
</v-container>

</template>

<script>
import ProfileCard from "../components/ProfileCard";


export default {
    name: 'MyProfile',

    components: {
        ProfileCard,
    }
}
</script>