<template>
<v-container fluid>

    <v-row justify="center">

        <ProfileCard :editMode="editMode" :profileData="profileData" :isLoading="profileLoading"></ProfileCard>

    </v-row>

    <!-- <v-tooltip top>
        <template v-slot:activator="{on, attrs}">
            <v-fab-transition>
                <v-btn
                    v-show="editMode"
                    fab fixed bottom right color="blue" dark
                    v-bind="attrs" v-on="on"
                    @click="save"
                ><v-icon>mdi-content-save</v-icon>
                </v-btn>
            </v-fab-transition>
        </template>
        <span>Save</span>
    </v-tooltip>
     -->
</v-container>

</template>

<script>
import ProfileCard from "../components/ProfileCard";


export default {
    name: 'MyProfile',


    data() {
        return {
            editMode: true,
            profileLoading: false,
            profileData: {}
        }
    },


    methods: {
        getProfileData() {
            this.profileLoading = true
            const data = window.axios.get('/api/kpbi/profile')
                            .then(({data}) => {
                                this.profileLoading = false
                                console.log(data)
                                return data
                            })
                            .catch(({data: err}) => err)

            this.profileData = data
        },


        save() {
            console.log('saved!')
        },
    },


    mounted() {
        this.getProfileData()
    },


    components: {
        ProfileCard,
    }
}
</script>