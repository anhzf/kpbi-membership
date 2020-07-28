<template>

<v-card :loading="isLoading" width="100%" max-width="650" elevation="4">
    <v-card-text>
        <v-container fluid>
            <v-row>

                <v-col cols="8">
                    <v-list-item v-for="(item, index) in form" :key="index" rounded ripple>

                        <v-list-item-avatar v-if="'icon' in item">
                            <v-icon v-text="item.icon"></v-icon>
                        </v-list-item-avatar>

                        <v-list-item-content v-if="Array.isArray(item.value)">
                            <v-row>

                                <v-col v-for="(subItem, subIndex) in item.value" :key="subIndex">

                                    <v-list-item-subtitle>{{ subItem.label }}</v-list-item-subtitle>
                                    <v-list-item-title>{{ subItem.value }}</v-list-item-title>
                                </v-col>

                            </v-row>
                        </v-list-item-content>

                        <v-list-item-content v-else>
                            
                            <v-list-item-subtitle>{{ item.label }}</v-list-item-subtitle>
                            <v-list-item-title>{{ item.value }}</v-list-item-title>
                        </v-list-item-content>

                    </v-list-item>
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

            // jenjang: null,
            // prodi: null,
            // jurusan: null,
            // fakultas: null,
            // pt: {
            //     lengkap: null,
            //     singkat: null,
            // },
            // status: null,
            // akreditasi_prodi: {
            //     akreditasi: null,
            //     tanggal_akreditasi: null,
            //     internasional: null,
            // },
            // akreditasi_pt: null,
            // web_prodi: null,
            // alamat: {
            //     alamat: null,
            //     kota: null,
            //     provinsi: null,
            // },
            // kaprodi: {
            //     nama: null,
            //     email: null,
            //     periode: {
            //         mulai: null,
            //         purna: null,
            //     }
            // },
            // email_prodi: null,
            // no_kantor: null,
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