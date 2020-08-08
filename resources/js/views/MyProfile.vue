<template>
<v-container fluid>

    <v-row justify="center">
        <h1 class="text-h5 my-6">{{ pageTitle }}</h1>
    </v-row>
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

    computed: {
        currentUserId() {
            return this.$store.getters.userId
        },
        pageTitle() {
            return `${this.profileData.jenjang ?? ''} ${this.profileData.nama_prodi ?? ''} ${this.profileData.pt?.lengkap ?? ''}`
        }
    },

    methods: {
        async getProfileData() {
            this.profileLoading = true
            try {
                const {data} = await window.axios('/api/kpbi/profile')
                this.profileData = data
                if ('warn' in data)
                    this.$emit('notice', {message: data.warn,type: 'warning'})
            } catch (err) {
                this.$emit('noticeError', err)                
            }
            this.profileLoading = false
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

    watch: {
        currentUserId() {
            this.getProfileData()
        }
    },

    components: {
        ProfileCard,
    }
}
</script>