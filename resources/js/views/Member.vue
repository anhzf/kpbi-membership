<template>

<v-container fluid>
    <v-row justify="start" align="stretch">

        <v-col>
            <v-card elevation="3">

                <v-card-title class="px-8 py-3">
                    
                    <v-tooltip bottom>
                        <template v-slot:activator="{on, attrs}">
                            <v-btn
                                @click.stop="getUsers"
                                :loading="isLoading"
                                :disabled="isLoading"
                                v-bind="attrs"
                                v-on="on"
                                fab
                                icon
                            >
                                <v-icon>mdi-refresh</v-icon>
                            </v-btn>
                        </template>
                        <span>Refresh Data</span>
                    </v-tooltip>

                    <h1 class="text-h5">Anggota KPBI</h1>

                    <v-spacer></v-spacer>
                    
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                    
                </v-card-title>

                <v-data-table
                    :headers="headers"
                    :items="members"
                    :search="search"
                    :loading="isLoading"
                    fixed-header
                    height="450"
                >

                    <template v-slot:item.web_prodi="{ item }">
                        <a :href="item.web_prodi" target="_blank">{{ item.web_prodi }}</a>
                    </template>
                    
                </v-data-table>

            </v-card>
        </v-col>

    </v-row>
</v-container>

</template>

<script>
export default {
    name: 'Members',

    data() {
        return {
            headers: [
                { text: '#', value: 'no', sortable: false },
                {
                    text: 'JENJANG',
                    align: 'start',
                    sortable: true,
                    value: 'jenjang',
                },
                { text: 'PRODI', value: 'nama_prodi' },
                { text: 'PERGURUAN TINGGI', value: 'pt.lengkap' },
                { text: 'WEBSITE PRODI', value: 'web_prodi', sortable: false },
            ],
            members: [],
            isLoading: false,
            search: null
        }
    },


    methods: {
        getUsers() {
            this.isLoading = true

            window.axios.get('/api/users')
                .then(({data}) => {
                    this.isLoading = false
                    this.members = data
                })
                .catch(err => console.log(err))
        }
    },

    
    created() {
        this.getUsers()
    }
}
</script>
