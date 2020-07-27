<template>

<v-card width="100%" max-width="650" elevation="4">
    <!-- <v-card-title primary-title>S1 PBIO UNS</v-card-title> -->
    <!-- <v-divider></v-divider> -->
    <v-card-text>
        <v-container fluid>
            <v-row>

                <v-col cols="8">

                    <v-row>
                        <v-col cols="4">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-select
                                    label="Jenjang" v-model="jenjang" :items="['S1','S2','S3']"
                                    prepend-icon="mdi-school" dense outlined
                                ></v-select>
                            </div>
                        </v-col>
                        <v-col cols="8">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Prodi" v-model="prodi"
                                    dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Jurusan" v-model="jurusan"
                                    prepend-icon="mdi-warehouse" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Fakultas" v-model="fakultas"
                                    prepend-icon="mdi-domain" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="9">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Nama Lengkap Perguruan Tinggi" v-model="pt.lengkap"
                                    prepend-icon="mdi-school-outline" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                        <v-col cols="3">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Singkatan" v-model="pt.singkat"
                                    dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>    

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-select
                                    label="Status Perguruan Tinggi" v-model="status" :items="['Negeri','Swasta']"
                                    prepend-icon="mdi-shield-check" dense outlined
                                ></v-select>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Akreditasi Prodi" v-model="akreditasi_prodi.akreditasi"
                                    prepend-icon="mdi-check-underline" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                        <v-col cols="6">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Tanggal Akreditasi" v-model="akreditasi_prodi.tanggal"
                                    prepend-icon="mdi-calendar" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Akreditasi Internasional" v-model="akreditasi_prodi.internasional"
                                    prepend-icon="mdi-earth" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Alamat Web Prodi" v-model="web_prodi"
                                    prepend-icon="mdi-web" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Alamat Kampus" v-model="alamat.alamat"
                                    prepend-icon="mdi-map-marker" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Kota/Kabupaten" v-model="alamat.kota"
                                    prepend-icon="mdi-map-marker" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Provinsi" v-model="alamat.provinsi"
                                    dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Nama Lengkap dan Gelar Kaprodi" v-model="kaprodi.nama"
                                    prepend-icon="mdi-account" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Periode Jabatan Kaprodi (mulai)" v-model="kaprodi.periode.mulai"
                                    prepend-icon="mdi-calendar-clock" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="(purna)" v-model="kaprodi.periode.purna"
                                    dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Email Kaprodi" v-model="kaprodi.email"
                                    prepend-icon="mdi-email" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Email Kaprodi" v-model="kaprodi.no"
                                    prepend-icon="mdi-contacts" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Email Prodi" v-model="email_prodi"
                                    prepend-icon="mdi-email" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field
                                    label="Nomer Telepon Kantor" v-model="no_kantor"
                                    prepend-icon="mdi-phone" dense outlined
                                ></v-text-field>
                            </div>
                        </v-col>
                    </v-row>

                </v-col>
                
                <v-col cols="4">
                    <v-skeleton-loader
                        type="image"
                        width="125"
                        height="125"
                        loading
                        class="mx-auto"
                    ></v-skeleton-loader>
                </v-col>

            </v-row>
        </v-container>
    </v-card-text>

</v-card>

</template>

<script>
export default {
    name: 'ProfileCard',

    props: {
        id: {
            default: ''
        },
        editMode: {
            type: Boolean,
            default: false,
        }
    },

    data() {
        return {
            isLoading: false,

            jenjang: null,
            prodi: null,
            jurusan: null,
            fakultas: null,
            pt: {},
            status: null,
            akreditasi_prodi: {},
            akreditasi_pt: null,
            web_prodi: null,
            alamat: {},
            kaprodi: {},
            email_prodi: null,
            no_kantor: null,
        }
    },


    methods: {
        getProfile() {
            this.isLoading = true
            window.axios.get('/api/kpbi/profile/'+this.id)
                .then(({data}) => {
                    (
                        {
                            jenjang: this.jenjang,
                            nama_prodi: this.prodi,
                            jurusan: this.jurusan,
                            fakultas: this.fakultas,
                            pt: this.pt,
                            status: this.status,
                            akreditasi_prodi: this.akreditasi_prodi,
                            akreditasi_pt: this.akreditasi_pt,
                            web_prodi: this.web_prodi,
                            alamat_kampus: this.alamat,
                            kaprodi: this.kaprodi,
                            email_prodi: this.email_prodi,
                            no_telp_prodi: this.no_kantor,
                        } = data
                    )
                    this.isLoading = false
                })
                .catch(err => console.log(err))
        }
    },


    mounted() {
        this.getProfile()
    },


    watch: {
        id() {
            this.getProfile()
        }
    }
}
</script>