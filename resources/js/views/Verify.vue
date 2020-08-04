<template>
<v-container fluid class="fill-height">
    <v-row justify="center">
        <h1 class="text-h4">Memverifikasi...</h1>
    </v-row>
</v-container>
</template>

<script>
export default {
    name: 'Verify',
    methods: {
        async verify() {
            this.$store.commit('contentLoading', true)

            if (this.$route.params.id != this.$store.getters.userId) {
                return this.$emit('notice',{message: 'Link verifikasi tidak sesuai, Silahkan Log in menggunakan akun yang lain', type: 'error'})
            }

            try {
                const verify = await window.axios.post(app.$route.fullPath)
                this.$emit('notice', {message: verify.data.message, type: 'success'})
                this.$router.push({name: 'AccountSettings'})
            } catch (err) {
                this.$emit('noticeError', err)
            }
            
            this.$store.commit('contentLoading', false)
        }
    },
    async mounted() {
        this.verify()
    }
}
</script>