<template>

<v-card
    width="100%" max-width="650"
    :style="cardStyle"
    :loading="isLoading"
    elevation="4"
>
    <v-card-text>
        <v-container fluid>
            <v-row>

                <v-col cols="12" sm="8" order="1" order-sm="0">

                    <profile-list-item v-if="editMode">
                        <v-row>
                            <v-col cols="3">
                                <profile-list-item-content
                                    label="Jenjang"
                                    v-model="jenjang"
                                    :choices="['S1','S2','S3']"
                                    :edit-mode="editMode"
                                />
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="Nama prodi"
                                    v-model="nama_prodi"
                                    :edit-mode="editMode"
                                />
                            </v-col>
                        </v-row>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-warehouse" v-if="(jurusan && (jurusan !== '-')) || editMode">
                        <profile-list-item-content
                            label="Jurusan"
                            v-model="jurusan"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-domain">
                        <profile-list-item-content
                            label="Fakultas"
                            v-model="fakultas"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>
                    
                    <profile-list-item v-if="editMode" icon="mdi-school">
                        <v-row>
                            <v-col>
                                <profile-list-item-content
                                    label="Nama Perguruan Tinggi (lengkap)"
                                    v-model="ptLengkap"
                                    :edit-mode="editMode"
                                />
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="(singkat)"
                                    v-model="ptSingkat"
                                    :edit-mode="editMode"
                                />
                            </v-col>
                        </v-row>
                    </profile-list-item>

                    <profile-list-item icon="mdi-checkbox-marked-circle-outline" v-if="editMode">
                        <profile-list-item-content
                            label="Status Perguruan Tinggi"
                            v-model="status"
                            :edit-mode="editMode"
                            :choices="['Negeri', 'Swasta']"
                        />
                    </profile-list-item>

                    <profile-list-item icon="mdi-check-underline" v-if="editMode">
                        <profile-list-item-content
                            label="Akreditasi Perguruan Tinggi"
                            v-model="akreditasi_pt"
                            :edit-mode="editMode"
                            :choices="['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi']"
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-check-underline">
                        <v-row>
                            <v-col>
                                <profile-list-item-content
                                    label="Akreditasi Prodi"
                                    v-model="akreditasiProdi"
                                    :edit-mode="editMode"
                                    :choices="['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi']"
                                />
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="Tanggal Akreditasi"
                                    v-model="tanggalAkreditasiProdi"
                                    :edit-mode="editMode"
                                    type="date"
                                />
                            </v-col>
                        </v-row>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-earth" v-if="(internasionalAkreditasiProdi && (internasionalAkreditasiProdi !== '-')) || editMode">
                        <profile-list-item-content
                            label="Akreditasi/Sertifikasi Internasional"
                            v-model="internasionalAkreditasiProdi"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-map">
                        <profile-list-item-content
                            label="Alamat Kampus"
                            v-model="alamat"
                            :edit-mode="editMode"
                        />
                        <profile-list-item-content
                            label="Kota/Kabupaten"
                            v-model="kotaAlamat"
                            :edit-mode="editMode"
                        />
                        <profile-list-item-content
                            label="Provinsi"
                            v-model="provinsiAlamat"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-email">
                        <profile-list-item-content
                            label="Email Prodi"
                            v-model="email_prodi"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-phone">
                        <profile-list-item-content
                            label="Nomer Telpon Kantor"
                            v-model="no_telp_prodi"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>

                </v-col>
                
                <v-col cols="12" sm="4">
                    <v-row justify="center">
                        <editable-image
                            :src="ptImg" :editable="editMode"
                            width="125px" height="125px"
                            @image:changed="updatePTImg"
                        />
                    </v-row>
                    <v-row>
                        <v-col cols="12">

                            <h2 class="text-caption text-center font-weight-bold">{{ ptLengkap }} ({{ ptSingkat }})</h2>

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
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-calendar-clock">
                        <v-row>
                            <v-col>
                                <profile-list-item-content
                                    label="Mulai menjabat"
                                    v-model="periodeMulaiKaprodi"
                                    :edit-mode="editMode"
                                    type="number"
                                />
                            </v-col>
                            <v-col>
                                <profile-list-item-content
                                    label="Akhir jabatan"
                                    v-model="periodePurnaKaprodi"
                                    :edit-mode="editMode"
                                    type="number"
                                />
                            </v-col>
                        </v-row>
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-email">
                        <profile-list-item-content
                            label="Email Kaprodi"
                            v-model="emailKaprodi"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-phone">
                        <profile-list-item-content
                            label="Nomor HP Kaprodi"
                            v-model="noKaprodi"
                            :edit-mode="editMode"
                        />
                    </profile-list-item>
                    
                    <profile-list-item icon="mdi-web">
                        <profile-list-item-content
                            label="Website Prodi"
                            v-model="web_prodi"
                            :edit-mode="editMode"
                            type="url" hyperlink
                        />
                    </profile-list-item>
                </v-col>
                
                <v-col cols="12" sm="4">
                    <v-row justify="center">
                        <editable-image
                            :src="kaprodiImg" :editable="editMode"
                            width="125px" height="125px"
                            @image:changed="updateKaprodiImg"
                        />
                    </v-row>
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
import EditableImage from "./editableImage";

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
            jenjang: null,
            nama_prodi: null,
            jurusan: null,
            fakultas: null,
            ptLengkap: null,
            ptSingkat: null,
            ptImg: null,
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
            kaprodiImg: null,
            periodeMulaiKaprodi: null,
            periodePurnaKaprodi: null,
            newPTImg: null,
            newKaprodiImg: null,
            cardStyle: {
                background: 'url("./img/ICON_KPBI.png")',
                backgroundRepeat: 'no-repeat',
                backgroundPosition: '50%',
                backgroundSize: '70%',
                backgroundColor: '#ffffffd9',
                backgroundBlendMode: 'color',
            }
        }
    },

    methods: {
        async fetchProfileData() {
            this.$store.commit('contentLoading', true);

            ({
                jenjang: this.jenjang = null,
                nama_prodi: this.nama_prodi = null,
                jurusan: this.jurusan = null,
                fakultas: this.fakultas = null,
                pt: {
                    singkat: this.ptSingkat = null,
                    lengkap: this.ptLengkap = null,
                } = { singkat: this.ptSingkat = null, lengkap: this.ptLengkap = null },
                status: this.status = null,
                akreditasi_prodi: {
                    akreditasi: this.akreditasiProdi = null,
                    tanggal: this.tanggalAkreditasiProdi = null,
                    internasional: this.internasionalAkreditasiProdi = null,
                } = { akreditasi: this.akreditasiProdi = null, tanggal: this.tanggalAkreditasiProdi = null, internasional: this.internasionalAkreditasiProdi = null },
                akreditasi_pt: this.akreditasi_pt = null,
                web_prodi: this.web_prodi = null,
                alamat_kampus: {
                    alamat: this.alamat = null,
                    kota: this.kotaAlamat = null,
                    provinsi: this.provinsiAlamat = null,
                } = { alamat: this.alamat = null, kota: this.kotaAlamat = null, provinsi: this.provinsiAlamat = null },
                kaprodi: {
                    nama: this.namaKaprodi = null,
                    no: this.noKaprodi = null,
                    email: this.emailKaprodi = null,
                    periode: {
                        mulai: this.periodeMulaiKaprodi = null,
                        purna: this.periodePurnaKaprodi = null,
                    } = { mulai: this.periodeMulaiKaprodi = null, purna: this.periodePurnaKaprodi = null },
                } = { nama: this.namaKaprodi = null, no: this.noKaprodi = null, email: this.emailKaprodi = null, periode: { mulai: this.periodeMulaiKaprodi = null, purna: this.periodePurnaKaprodi = null, } = { mulai: this.periodeMulaiKaprodi = null, purna: this.periodePurnaKaprodi = null } },
                email_prodi: this.email_prodi = null,
                no_telp_prodi: this.no_telp_prodi = null,
                ptImg_src: this.ptImg = null,
                kaprodiImg_src: this.kaprodiImg = null,
            } = await this.profileData)

            this.$store.commit('contentLoading', false)
        },

        updateProfile() {
            this.editMode = false
            this.$emit('profile-update', {
                bio: {
                    jenjang: this.jenjang,
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
                },
                newImg: {
                    pt: this.newPTImg,
                    kaprodi: this.newKaprodiImg
                }
            })
        },

        updatePTImg({file, base64}) {
            this.ptImg = base64
            this.newPTImg = file
        },

        updateKaprodiImg({file, base64}) {
            this.kaprodiImg = base64
            this.newKaprodiImg = file
        }
    },

    mounted() {
        this.fetchProfileData()
    },

    watch: {
        profileData() {
            this.fetchProfileData()
        }
    },

    components: {
        ProfileListItem,
        ProfileListItemContent,
        EditableImage,
    }
}
</script>