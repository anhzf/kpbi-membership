<template>

<v-card width="100%" max-width="650" elevation="4">
    <!-- <v-card-title primary-title>S1 PBIO UNS</v-card-title> -->
    <!-- <v-divider></v-divider> -->
    <v-card-text>
        <v-container fluid>
            <v-row>

                <v-col cols="8">

                    <v-list-item>
                        <v-list-item-avatar>
                            <v-icon>mdi-school</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <v-list-item-title>{{ jenjang }}</v-list-item-title>
                            <v-list-item-subtitle>Jenjang</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <!-- <v-row>
                        <v-col cols="12">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-select v-if="editMode"
                                    label="Jenjang" v-model="jenjang" :items="['S1','S2','S3']"
                                    prepend-icon="mdi-school" dense outlined
                                ></v-select>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-school</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ jenjang }}</v-list-item-title>
                                        <v-list-item-subtitle>Jenjang</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                        <v-col cols="8">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Prodi" v-model="prodi"
                                    dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ prodi }}</v-list-item-title>
                                        <v-list-item-subtitle>Prodi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Jurusan" v-model="jurusan"
                                    prepend-icon="mdi-warehouse" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-warehouse</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ jurusan }}</v-list-item-title>
                                        <v-list-item-subtitle>Jurusan</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Fakultas" v-model="fakultas"
                                    prepend-icon="mdi-domain" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-domain</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ fakultas }}</v-list-item-title>
                                        <v-list-item-subtitle>Fakultas</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col cols="9">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Nama Lengkap Perguruan Tinggi" v-model="pt.lengkap"
                                    prepend-icon="mdi-school-outline" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-school</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ pt.lengkap }}</v-list-item-title>
                                        <v-list-item-subtitle>Nama Lengkap Perguruan Tinggi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                        <v-col cols="3">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Singkatan" v-model="pt.singkat"
                                    dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ pt.singkat }}</v-list-item-title>
                                        <v-list-item-subtitle>Singkatan</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row>     -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-select v-if="editMode"
                                    label="Status Perguruan Tinggi" v-model="status" :items="['Negeri','Swasta']"
                                    prepend-icon="mdi-shield-check" dense outlined
                                ></v-select>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-shield</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ status }}</v-list-item-title>
                                        <v-list-item-subtitle>Status Perguruan Tinggi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col cols="6">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Akreditasi Prodi" v-model="akreditasi_prodi.akreditasi"
                                    prepend-icon="mdi-check-underline" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-check</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ akreditasi_prodi.akreditasi }}</v-list-item-title>
                                        <v-list-item-subtitle>Akreditasi Prodi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                        <v-col cols="6">
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Tanggal Akreditasi" v-model="akreditasi_prodi.tanggal"
                                    prepend-icon="mdi-calendar" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ akreditasi_prodi.tanggal }}</v-list-item-title>
                                        <v-list-item-subtitle>Tanggal Akreditasi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Akreditasi Internasional" v-model="akreditasi_prodi.internasional"
                                    prepend-icon="mdi-earth" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-earth</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ akreditasi_prodi.internasional }}</v-list-item-title>
                                        <v-list-item-subtitle>Akreditasi Internasional</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Alamat Web Prodi" v-model="web_prodi"
                                    prepend-icon="mdi-web" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-web</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ web_prodi }}</v-list-item-title>
                                        <v-list-item-subtitle>Alamat Web Prodi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Alamat Kampus" v-model="alamat.alamat"
                                    prepend-icon="mdi-map-marker" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-map</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ alamat.alamat }}</v-list-item-title>
                                        <v-list-item-subtitle>Alamat Kampus</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Kota/Kabupaten" v-model="alamat.kota"
                                    prepend-icon="mdi-map-marker" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-map</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ alamat.kota }}</v-list-item-title>
                                        <v-list-item-subtitle>Kota/Kabupaten</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Provinsi" v-model="alamat.provinsi"
                                    dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ alamat.provinsi }}</v-list-item-title>
                                        <v-list-item-subtitle>Provinsi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Nama Lengkap dan Gelar Kaprodi" v-model="kaprodi.nama"
                                    prepend-icon="mdi-account" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-account</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ kaprodi.nama }}</v-list-item-title>
                                        <v-list-item-subtitle>Nama Lengkap dan Gelar Kaprodi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Periode Jabatan Kaprodi (mulai)" v-model="kaprodi.periode.mulai"
                                    prepend-icon="mdi-calendar-clock" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ kaprodi.periode.mulai }}</v-list-item-title>
                                        <v-list-item-subtitle>Periode Jabatan Kaprodi (mulai)</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="(purna)" v-model="kaprodi.periode.purna"
                                    dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ kaprodi.periode.purna }}</v-list-item-title>
                                        <v-list-item-subtitle>purna)</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Email Kaprodi" v-model="kaprodi.email"
                                    prepend-icon="mdi-email" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-email</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ kaprodi.email }}</v-list-item-title>
                                        <v-list-item-subtitle>Email Kaprodi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Email Kaprodi" v-model="kaprodi.no"
                                    prepend-icon="mdi-contacts" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-contacts</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ kaprodi.no }}</v-list-item-title>
                                        <v-list-item-subtitle>Email Kaprodi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Email Prodi" v-model="email_prodi"
                                    prepend-icon="mdi-email" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-email</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ email_prodi }}</v-list-item-title>
                                        <v-list-item-subtitle>Email Prodi</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                    <!-- <v-row>
                        <v-col>
                            <v-skeleton-loader type="text" v-if="isLoading"></v-skeleton-loader>
                            <div v-else>
                                <v-text-field v-if="editMode"
                                    label="Nomer Telepon Kantor" v-model="no_kantor"
                                    prepend-icon="mdi-phone" dense outlined
                                ></v-text-field>
                                <v-list-item v-else>
                                    <v-list-item-icon>
                                        <v-icon>mdi-phone</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>{{ no_kantor }}</v-list-item-title>
                                        <v-list-item-subtitle>Nomer Telepon Kantor</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </div>
                        </v-col>
                    </v-row> -->

                </v-col>
                
                <v-col cols="4">
                    <v-skeleton-loader
                        type="image"
                        width="125" height="125"
                        :boilerplate="!isLoading" class="mx-auto"
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
        profileData: {
            type: Object,
            required: true
        },
        editMode: {
            type: Boolean,
            default: false,
        },
        isLoading: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            jenjang: null,
            prodi: null,
            jurusan: null,
            fakultas: null,
            pt: {
                lengkap: null,
                singkat: null,
            },
            status: null,
            akreditasi_prodi: {
                akreditasi: null,
                tanggal_akreditasi: null,
                internasional: null,
            },
            akreditasi_pt: null,
            web_prodi: null,
            alamat: {
                alamat: null,
                kota: null,
                provinsi: null,
            },
            kaprodi: {
                nama: null,
                email: null,
                periode: {
                    mulai: null,
                    purna: null,
                }
            },
            email_prodi: null,
            no_kantor: null,
        }
    },


    methods: {
        async fetchProfileData() {
            ({
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
            } = await this.profileData)
            
            const form = {
                jenjang: null,
                prodi: null,
                jurusan: null,
                fakultas: null,
                pt: {
                    lengkap: null,
                    singkat: null,
                },
                status: null,
                akreditasi_prodi: {
                    akreditasi: null,
                    tanggal_akreditasi: null,
                    internasional: null,
                },
                akreditasi_pt: null,
                web_prodi: null,
                alamat: {
                    alamat: null,
                    kota: null,
                    provinsi: null,
                },
                kaprodi: {
                    nama: null,
                    email: null,
                    periode: {
                        mulai: null,
                        purna: null,
                    }
                },
                email_prodi: null,
                no_kantor: null,
            }

        }
    },


    mounted() {
        this.fetchProfileData()
    },


    watch: {
        profileData() {
            this.fetchProfileData()
        }
    }
}
</script>