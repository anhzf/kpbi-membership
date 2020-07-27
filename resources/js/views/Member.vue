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

                    <template v-slot:item.actions="{ item }">
                        <v-btn outlined small color="purple" @click="detailDialog = true">Details</v-btn>
                    </template>

                </v-data-table>

            </v-card>
        </v-col>

    </v-row>

    <v-dialog
      v-model="detailDialog"
      max-width="290"
    >
        <v-card>
            <v-card-title class="headline">Use Google's location service?</v-card-title>

            <v-card-text>
            Let Google help apps determine location. This means sending anonymous location data to Google, even when no apps are running.
            </v-card-text>

            <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
                color="green darken-1"
                text
                @click="detailDialog = false"
            >
                Disagree
            </v-btn>

            <v-btn
                color="green darken-1"
                text
                @click="detailDialog = false"
            >
                Agree
            </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</v-container>

</template>

<script>
export default {
    name: 'Members',

    data() {
        return {
            headers: [
                { text: '#', value: 'no', sortable: false },
                { text: 'JENJANG', align: 'start', sortable: true, value: 'jenjang' },
                { text: 'PRODI', value: 'nama_prodi' },
                { text: 'PERGURUAN TINGGI', value: 'pt.lengkap' },
                { text: 'WEBSITE PRODI', value: 'web_prodi', sortable: false },
                { text: 'AKSI', value: 'actions', sortable: false },
            ],
            members: [],
            isLoading: false,
            search: null,

            detailDialog: false,
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
