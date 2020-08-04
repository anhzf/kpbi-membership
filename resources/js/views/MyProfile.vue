<template>
<v-container fluid>

    <v-row justify="center">

        <ProfileCard
            :can-edit="true"
            :profileData="profileData"
            :isLoading="profileLoading"
            @profile-update="save"
        ></ProfileCard>

    </v-row>
    
</v-container>

</template>

<script>
import ProfileCard from "../components/ProfileCard";


export default {
    name: 'MyProfile',

    data() {
        return {
            profileLoading: false,
            profileData: {}
        }
    },

    methods: {
        async getProfileData() {
            this.profileLoading = true
            const data = window.axios.get('/api/kpbi/profile')
                            .then(({data}) => {
                                this.profileLoading = false
                                return data
                            })
                            .catch(({data: err}) => err)

            this.profileData = await data
        },

        async save(data) {
            this.$store.commit('contentLoading', true)
            try {
                const update = await window.axios.put('/api/kpbi/profile', data)
                this.$emit('notice', {message: update.data.message, type: 'success'})
            } catch (err) {
                this.$emit('noticeError', err)
            }
            this.getProfileData()
            this.$store.commit('contentLoading', false)
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