<template>

<v-card :loading="isLoading" width="100%" max-width="650" elevation="4">
    <v-card-text>
        <v-container fluid>
            <v-row>

                <v-col cols="12" sm="8" order="1" order-sm="0">

                    <profile-list-item>
                        <v-row v-if="editMode">
                            <v-col cols="3">
                                <profile-list-item-content
                                    label="Jenjang"
                                    v-model="jenjang.value"
                                    :choices="jenjang.choices"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="Nama prodi"
                                    v-model="nama_prodi"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                        </v-row>
                        <template v-else>
                            <v-list-item-title>
                                <h1 class="text-h5">{{ jenjang.value }} {{ nama_prodi }} {{ ptLengkap }}</h1>
                                <v-divider></v-divider>
                            </v-list-item-title>
                        </template>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-warehouse">
                        <profile-list-item-content
                            label="Jurusan"
                            v-model="jurusan"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-domain">
                        <profile-list-item-content
                            label="Fakultas"
                            v-model="fakultas"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-school">
                        <v-row v-if="editMode">
                            <v-col>
                                <profile-list-item-content
                                    label="Nama Perguruan Tinggi (lengkap)"
                                    v-model="ptLengkap"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="(singkat)"
                                    v-model="ptSingkat"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                        </v-row>
                        <template v-else>
                            <v-list-item-subtitle>Perguruan Tinggi</v-list-item-subtitle>
                            <v-list-item-title>{{ ptLengkap }} ({{ ptSingkat }})</v-list-item-title>
                        </template>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-check-underline">
                        <v-row>
                            <v-col>
                                <profile-list-item-content
                                    label="Akreditasi Prodi"
                                    v-model="akreditasiProdi"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="Tanggal Akreditasi"
                                    v-model="tanggalAkreditasiProdi"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                        </v-row>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-earth">
                        <profile-list-item-content
                            label="Akreditasi Internasional"
                            v-model="internasionalAkreditasiProdi"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-map">
                        <profile-list-item-content
                            label="Alamat Kampus"
                            v-model="alamat"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                        <profile-list-item-content
                            label="Kota/Kabupaten"
                            v-model="kotaAlamat"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                        <profile-list-item-content
                            label="Provinsi"
                            v-model="provinsiAlamat"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-email">
                        <profile-list-item-content
                            label="Email Prodi"
                            v-model="email_prodi"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-phone">
                        <profile-list-item-content
                            label="Nomer Telpon Kantor"
                            v-model="no_telp_prodi"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>

                </v-col>
                
                <v-col cols="12" sm="4">
                    <v-row>
                        <v-skeleton-loader
                            type="image"
                            width="125" height="125"
                            :boilerplate="!isLoading" class="mx-auto"
                        ></v-skeleton-loader>
                    </v-row>
                    <v-row>
                        <v-col cols="12">

                            <h2 class="text-caption text-center">{{ ptLengkap }} ({{ ptSingkat }})</h2>

                            <v-row dense>
                                <v-col cols="6">
                                    <h2 class="text-caption text-right">Akreditasi</h2>
                                </v-col>
                                <v-col cols="6">
                                    <h2 class="text-subtitle-2 text-left">{{ akreditasi_pt }}</h2>
                                </v-col>
                            </v-row>

                            <v-row dense>
                                <v-col cols="6">
                                    <h2 class="text-caption text-right">Status PT</h2>
                                </v-col>
                                <v-col cols="6">
                                    <h2 class="text-subtitle-2 text-left">{{ status }}</h2>
                                </v-col>
                            </v-row>

                        </v-col>
                    </v-row>                    
                </v-col>

            </v-row>

            <v-row>
                <v-col cols="12" sm="8" order="1" order-sm="0">
                    <v-divider></v-divider>
                    <profile-list-item icon="mdi-account">
                        <profile-list-item-content
                            label="Kaprodi"
                            v-model="namaKaprodi"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-calendar-clock">
                        <v-row>
                            <v-col>
                                <profile-list-item-content
                                    label="Mulai menjabat"
                                    v-model="periodeMulaiKaprodi"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="Akhir jabatan"
                                    v-model="periodePurnaKaprodi"
                                    :edit-mode="editMode"
                                ></profile-list-item-content>
                            </v-col>
                        </v-row>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-email">
                        <profile-list-item-content
                            label="Email Kaprodi"
                            v-model="emailKaprodi"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-phone">
                        <profile-list-item-content
                            label="Nomor HP Kaprodi"
                            v-model="noKaprodi"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-web">
                        <profile-list-item-content
                            label="Website Prodi"
                            v-model="web_prodi"
                            :edit-mode="editMode"
                        ></profile-list-item-content>
                    </profile-list-item>
                </v-col>
                
                <v-col cols="12" sm="4">
                    <v-skeleton-loader
                        type="image"
                        width="125" height="125"
                        :boilerplate="!isLoading" class="mx-auto"
                    ></v-skeleton-loader>
                </v-col>

            </v-row>
        </v-container>
    </v-card-text>

    <v-tooltip top v-if="canEdit">
        <template v-slot:activator="{on, attrs}">
            <v-fab-transition>
                <v-btn
                    v-if="editMode"
                    fab fixed bottom right color="green" dark
                    v-bind="attrs" v-on="on"
                    @click="updateProfile"
                ><v-icon>mdi-check</v-icon>
                </v-btn>
                <v-btn
                    v-else
                    fab fixed bottom right color="blue" dark
                    v-bind="attrs" v-on="on"
                    @click="editMode = true"
                ><v-icon>mdi-pencil</v-icon>
                </v-btn>
            </v-fab-transition>
        </template>
        <span v-if="editMode">Save</span>
        <span v-else>Edit</span>
    </v-tooltip>

</v-card>

</template>

<script>
import ProfileListItem from "./ProfileListItem";
import ProfileListItemContent from "./ProfileListItemContent";


export default {
    name: 'ProfileCard',

    props: {
        profileData: {
            required: true
        },
        canEdit: {
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
            editMode: false,
            jenjang: {
                value: null,
                choices: ['S1', 'S2', 'S3'],
            },
            nama_prodi: null,
            jurusan: null,
            fakultas: null,
            ptLengkap: null,
            ptSingkat: null,
            status: null,
            akreditasiProdi: null,
            tanggalAkreditasiProdi: null,
            internasionalAkreditasiProdi: null,
            akreditasi_pt: null,
            email_prodi: null,
            no_telp_prodi: null,
            web_prodi: null,
            alamat: null,
            kotaAlamat: null,
            provinsiAlamat: null,
            namaKaprodi: null,
            noKaprodi: null,
            emailKaprodi: null,
            periodeMulaiKaprodi: null,
            periodePurnaKaprodi: null,
        }
    },

    methods: {
        async fetchProfileData() {
            this.$store.commit('contentLoading', true);

            ({
                jenjang: this.jenjang.value,
                nama_prodi: this.nama_prodi,
                jurusan: this.jurusan,
                fakultas: this.fakultas,
                pt: {
                    singkat: this.ptSingkat,
                    lengkap: this.ptLengkap,
                },
                status: this.status,
                akreditasi_prodi: {
                    akreditasi: this.akreditasiProdi,
                    tanggal: this.tanggalAkreditasiProdi,
                    internasional: this.internasionalAkreditasiProdi,
                },
                akreditasi_pt: this.akreditasi_pt,
                web_prodi: this.web_prodi,
                alamat_kampus: {
                    alamat: this.alamat,
                    kota: this.kotaAlamat,
                    provinsi: this.provinsiAlamat,
                },
                kaprodi: {
                    nama: this.namaKaprodi,
                    no: this.noKaprodi,
                    email: this.emailKaprodi,
                    periode: {
                        mulai: this.periodeMulaiKaprodi,
                        purna: this.periodePurnaKaprodi,
                    },
                },
                email_prodi: this.email_prodi,
                no_telp_prodi: this.no_telp_prodi,
            } = await this.profileData)

            this.$store.commit('contentLoading', false)
        },


        updateProfile() {
            this.editMode = false
            this.$emit('profile-update', {
                jenjang: this.jenjang.value,
                nama_prodi: this.nama_prodi,
                jurusan: this.jurusan,
                fakultas: this.fakultas,
                pt: {
                    singkat: this.ptSingkat,
                    lengkap: this.ptLengkap,
                },
                status: this.status,
                akreditasi_prodi: {
                    akreditasi: this.akreditasiProdi,
                    tanggal: this.tanggalAkreditasiProdi,
                    internasional: this.internasionalAkreditasiProdi,
                },
                akreditasi_pt: this.akreditasi_pt,
                web_prodi: this.web_prodi,
                alamat_kampus: {
                    alamat: this.alamat,
                    kota: this.kotaAlamat,
                    provinsi: this.provinsiAlamat,
                },
                kaprodi: {
                    nama: this.namaKaprodi,
                    no: this.noKaprodi,
                    email: this.emailKaprodi,
                    periode: {
                        mulai: this.periodeMulaiKaprodi,
                        purna: this.periodePurnaKaprodi,
                    },
                },
                email_prodi: this.email_prodi,
                no_telp_prodi: this.no_telp_prodi,
            })
        }
    },


    watch: {
        profileData() {
            this.fetchProfileData()
        }
    },


    components: {
        ProfileListItem,
        ProfileListItemContent
    }
}
</script>