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

          <v-spacer></v-spacer>

          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line hide-details
          ></v-text-field>

        </v-card-title>

        <v-data-table
          :headers="headers"
          :items="members"
          :search="search"
          :loading="isLoading"
          fixed-header
          height="65vh"
        >
          <template v-slot:item.web_prodi="{ item }">
            <a :href="item.web_prodi" target="_blank">{{ item.web_prodi }}</a>
          </template>

          <template v-slot:item.actions="{ item }">
            <v-btn outlined small color="green darken-2" @click="seeDetails(item)">Details</v-btn>
          </template>

        </v-data-table>

      </v-card>
    </v-col>

  </v-row>

  <v-dialog
    v-model="detailDialog"
    width="700"
    max-width="100%"
    scrollable
  >
    <v-card>
      <v-card-title class="light-green white--text">{{ dialogTitle }}</v-card-title>

      <v-card-text>
        <v-container fluid>
          <v-row justify="center">
            <profile-card :profileData="currentProfileShow" :editMode="false"></profile-card>
          </v-row>
        </v-container>
      </v-card-text>

      <v-card-actions class="light-green lighten-4">
        <v-spacer></v-spacer>
        <v-btn color="red" text @click="detailDialog = false">Close</v-btn>
      </v-card-actions>

    </v-card>
  </v-dialog>

</v-container>

</template>

<script>
import ProfileCard from "../components/ProfileCard";


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

  components: {
    ProfileCard,
  }
}
</script>
