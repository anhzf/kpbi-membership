<template>

<v-card width="100%" max-width="650" :loading="isLoading" class="elevation4">
    <!-- <v-card-title primary-title>S1 PBIO UNS</v-card-title> -->
    <!-- <v-divider></v-divider> -->
    <v-card-text>
        <v-container fluid>
            <v-row>

                <v-col cols="8">

                    <v-row>
                        <v-col cols="4">
                            <v-text-field
                                label="Jenjang"
                                v-model="jenjang"
                                prepend-icon="mdi-school"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="8">
                            <v-text-field
                                label="Prodi"
                                v-model="prodi"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Jurusan"
                                v-model="jurusan"
                                prepend-icon="mdi-warehouse"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Fakultas"
                                v-model="fakultas"
                                prepend-icon="mdi-domain"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="9">
                            <v-text-field
                                label="Nama Lengkap Perguruan Tinggi"
                                v-model="pt.lengkap"
                                prepend-icon="mdi-school-outline"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field
                                label="Singkatan"
                                v-model="pt.singkat"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>    

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Status Perguruan Tinggi"
                                v-model="status"
                                prepend-icon="mdi-shield-check"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6">
                            <v-text-field
                                label="Akreditasi Prodi"
                                v-model="akreditasi_prodi.akreditasi"
                                prepend-icon="mdi-check-underline"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                label="Tanggal Akreditasi"
                                v-model="akreditasi_prodi.tanggal"
                                prepend-icon="mdi-calendar"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Akreditasi Internasional"
                                v-model="akreditasi_prodi.internasional"
                                prepend-icon="mdi-earth"
                                dense
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Alamat Web Prodi"
                                v-model="web_prodi"
                                prepend-icon="mdi-web"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Alamat Kampus"
                                v-model="alamat.alamat"
                                prepend-icon="mdi-map-marker"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Kota/Kabupaten"
                                v-model="alamat.kota"
                                prepend-icon="mdi-map-marker"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col>
                            <v-text-field
                                label="Provinsi"
                                v-model="alamat.provinsi"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Nama Lengkap dan Gelar Kaprodi"
                                v-model="kaprodi.nama"
                                prepend-icon="mdi-account"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Periode Jabatan Kaprodi (mulai)"
                                v-model="kaprodi.periode.mulai"
                                prepend-icon="mdi-calendar-clock"
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col>
                            <v-text-field
                                label="(purna)"
                                v-model="kaprodi.periode.purna"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Email Kaprodi"
                                v-model="kaprodi.email"
                                prepend-icon="mdi-email"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Email Kaprodi"
                                v-model="kaprodi.no"
                                prepend-icon="mdi-contacts"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Email Prodi"
                                v-model="email_prodi"
                                prepend-icon="mdi-email"
                                dense
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col>
                            <v-text-field
                                label="Nomer Telepon Kantor"
                                v-model="no_kantor"
                                prepend-icon="mdi-phone"
                                dense
                            ></v-text-field>
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
            window.axios.get('/api/kpbi/profile')
                .then(({data}) => {
                    (
                        {
                            "jenjang": this.jenjang,
                            "nama_prodi": this.prodi,
                            "jurusan": this.jurusan,
                            "fakultas": this.fakultas,
                            "pt": this.pt,
                            "status": this.status,
                            "akreditasi_prodi": this.akreditasi_prodi,
                            "akreditasi_pt": this.akreditasi_pt,
                            "web_prodi": this.web_prodi,
                            "alamat_kampus": this.alamat,
                            "kaprodi": this.kaprodi,
                            "email_prodi": this.email_prodi,
                            "no_telp_prodi": this.no_kantor,
                        } = data
                    )
                    this.isLoading = false
                })
                .catch(err => console.log(err))
        }
    },


    mounted() {
        this.getProfile()
    }
}
</script>