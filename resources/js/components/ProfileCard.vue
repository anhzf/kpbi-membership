<template>

<v-card :loading="isLoading" width="100%" max-width="650" elevation="4">
    <v-card-text>
        <v-container fluid>
            <v-row>

                <v-col cols="12" sm="9" order="1" order-sm="0">
                    <template v-for="(item, index) in form">
                        <v-list-item>

                            <v-list-item-avatar v-if="'icon' in item">
                                <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-avatar>

                            <v-list-item-content v-if="Array.isArray(item.value)">
                                <v-row>
                                    <v-col v-for="(subItem, subIndex) in item.value" :key="subIndex">
                                        <ProfileField :item="subItem" :editMode="editMode"></ProfileField>
                                    </v-col>
                                </v-row>
                            </v-list-item-content>

                            <v-list-item-content v-else>
                                <ProfileField :item="item" :editMode="editMode"></ProfileField>
                            </v-list-item-content>

                        </v-list-item>
                        <v-divider v-if="editMode"></v-divider>
                    </template>
                </v-col>
                
                <v-col cols="12" sm="3">
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
import ProfileField from "./ProfileField";


export default {
    name: 'ProfileCard',

    props: {
        profileData: {
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
            form: [],
        }
    },


    methods: {
        async fetchProfileData() {
            const {
                jenjang, nama_prodi, jurusan, fakultas, pt, status, akreditasi_prodi, akreditasi_pt, web_prodi, alamat_kampus,
                kaprodi: {
                    nama: nama_kaprodi,
                    email: email_kaprodi,
                    no: telpon_kaprodi,
                    periode: periode_kaprodi,
                },
                email_prodi, no_telp_prodi,
            } = await this.profileData
            
            this.form = [
                {
                    icon: 'mdi-school',
                    value: [
                        {    
                            label: 'Jenjang',
                            value: jenjang,
                            choices: ['S1', 'S2', 'S3'],
                        },
                        {
                            label: 'Nama Prodi',
                            value: nama_prodi,
                        },
                    ]
                },
                {
                    label: 'Jurusan',
                    value: jurusan,
                    icon: 'mdi-warehouse',
                },
                {
                    label: 'Fakultas',
                    value: fakultas,
                    icon: 'mdi-domain'
                },
                {
                    icon: 'mdi-school',
                    value: [
                        {
                            label: 'Nama Perguruan Tinggi',
                            value: pt.lengkap
                        },
                        {
                            label: '(Singkatan)',
                            value: pt.singkat
                        },
                    ]
                },
                {
                    label: 'Status Perguruan Tinggi',
                    value: status,
                    icon: 'mdi-shield-check',
                    choices: ['Negeri', 'Swasta']
                },
                {
                    icon: 'mdi-check-underline',
                    value: [
                        {
                            label: 'Akreditasi Prodi',
                            value: akreditasi_prodi.akreditasi,
                        },
                        {
                            label: 'Tanggal Akreditasi',
                            value: akreditasi_prodi.tanggal,
                        },
                        {
                            label: 'Akreditasi Internasional',
                            value: akreditasi_prodi.internasional,
                        },
                    ],
                },
                {
                    label: 'Akreditasi Perguruan Tinggi',
                    value: akreditasi_pt,
                    icon: 'mdi-check-underline',
                },
                {
                    label: 'Website Prodi',
                    value: web_prodi,
                    icon: 'mdi-web'
                },
                {
                    icon: 'mdi-map',
                    value: [
                        {
                            label: 'Alamat Kampus',
                            value: alamat_kampus.alamat,
                        },
                        {
                            label: 'Kota',
                            value: alamat_kampus.kota,
                        },
                        {
                            label: 'Kota',
                            value: alamat_kampus.provinsi,
                        }
                    ],
                },
                {
                    label: 'Nama Kaprodi',
                    value: nama_kaprodi,
                    icon: 'mdi-account',
                },
                {
                    label: 'Email Kaprodi',
                    value: email_kaprodi,
                    icon: 'mdi-email',
                },
                {
                    label: 'No. Telp Kaprodi',
                    value: telpon_kaprodi,
                    icon: 'mdi-phone',
                },
                {
                    icon: 'mdi-calendar-clock',
                    value: [
                        {
                            label: 'Mulai menjabat',
                            value: periode_kaprodi.mulai,
                        },
                        {
                            label: 'Akhir jabatan',
                            value: periode_kaprodi.purna,
                        },
                    ],
                },
                {
                    label: 'Email Prodi',
                    value: email_prodi,
                    icon: 'mdi-email',
                },
                {
                    label: 'No Telp Kantor Prodi',
                    value: no_telp_prodi,
                    icon: 'mdi-phone',
                },
            ]
        },


        save() {
            console.log('saved!')
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
        ProfileField
    }
}
</script>