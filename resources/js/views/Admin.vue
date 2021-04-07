<template>

<v-container fluid>
  <v-row justify="start" align="stretch">

    <v-col>
      <v-card elevation="3">

        <v-card-title class="px-8 py-3">

          <v-tooltip bottom>
            <template v-slot:activator="{on, attrs}">
              <v-btn
                fab icon
                v-bind="attrs" v-on="on"
                :loading="isLoading"
                :disabled="isLoading"
                @click.stop="getUsers"
              >
                <v-icon>mdi-refresh</v-icon>
              </v-btn>
            </template>
            <span>Refresh Data</span>
          </v-tooltip>

          <h1 class="text-h5">Anggota KPBI</h1>

          <v-spacer />

          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line hide-details
          />

        </v-card-title>

        <v-data-table
          ref="hatiku"
          :headers="headers"
          :items="members"
          :search="search"
          :loading="isLoading"
          fixed-header
          height="65vh"
          show-expand single-expand :expanded.sync="expanded"
        >
          <template v-slot:item.web_prodi="{ item }">
            <a :href="item.web_prodi" target="_blank">{{ item.web_prodi }}</a>
          </template>

          <template v-slot:item.created_at="{ item }">
            {{ new Date(item.created_at).toLocaleDateString() }}
          </template>

          <template v-slot:expanded-item="{ headers, item }">
            <td :colspan="headers.length" class="py-6">
              <v-row justify="center">
                <v-btn small depressed color="info" class="mx-2">send email verification</v-btn>
                <v-btn small depressed color="info" class="mx-2">send password reset link</v-btn>
                <v-btn small depressed color="error" class="mx-2">delete user</v-btn>
              </v-row>
            </td>
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
      expanded: [],
      headers: [
        { text: '#', value: 'no', sortable: false },
        { text: 'JENJANG', align: 'start', sortable: true, value: 'jenjang' },
        { text: 'PRODI', value: 'nama_prodi' },
        { text: 'PERGURUAN TINGGI', value: 'pt.lengkap' },
        { text: 'TANGGAL REGISTRASI', value: 'created_at' },
        { text: '', value: 'data-table-expand' },
      ],
      members: [],
      isLoading: false,
      search: null,

      detailDialog: false,
      currentProfileShow: {}
    }
  },

  computed: {
    dialogTitle() {
      const profileData = this.currentProfileShow;
      return `${profileData.jenjang ?? ''} ${profileData.nama_prodi ?? ''} ${profileData.pt?.lengkap ?? ''}`
    }
  },

  methods: {
    async getUsers() {
      this.isLoading = true

      try {
        const {data: members} = await window.axios('/api/kpbi/profiles')
        this.members = members
      } catch (err) {
        this.$emit('noticeError', err)
      }

      this.isLoading = false
    },

    seeDetails(profileData) {
      this.currentProfileShow = profileData
      this.detailDialog = true
    }
  },

  created() {
    this.getUsers()
  },
}
</script>
