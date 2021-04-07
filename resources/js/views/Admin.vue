<template>

<v-container fluid>
  <v-row justify="start" align="stretch">

    <v-col>
      <v-card elevation="3">

        <v-card-title class="px-8 py-3">

          <v-tooltip bottom>
            <template #activator="{on, attrs}">
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
          show-expand
          single-expand
          :expanded.sync="expanded"
        >
          <template #item.web_prodi="{ item }">
            <a :href="item.web_prodi" target="_blank">{{ item.web_prodi }}</a>
          </template>

          <template #item.created_at="{ item }">
            <span class="mr-2">
              {{ new Date(item.created_at).toLocaleDateString() }}
            </span>
            <v-chip
              small
              color="green"
              text-color="white"
            >
              aktif sampai {{ addDate(new Date(item.created_at), activeMemberInterval).toLocaleDateString() }}
            </v-chip>
          </template>

          <template #expanded-item="{ headers, item }">
            <td :colspan="headers.length" class="py-6">
              <v-row justify="center">
                <v-btn
                  small
                  depressed
                  color="info"
                  class="mx-2"
                  @click="onSendEmailVerification(item.id)"
                >
                  send email verification
                </v-btn>
                <v-btn
                  small
                  depressed
                  color="info"
                  class="mx-2"
                  @click="onSendPasswordResetLink(item.id)"
                >
                  send password reset link
                </v-btn>
                <v-btn
                  small
                  depressed
                  color="error"
                  class="mx-2"
                  @click="onDeactiveUser(item.id)"
                >
                  deactivate user
                </v-btn>
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
import { addDate } from '@/util/Helper';

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
      currentProfileShow: {},
      activeMemberInterval: 1000 * 3600 * 30 * 12, // about a year
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
    },
    onSendEmailVerification(id) {
      const {jenjang, nama_prodi} = this.getMemberById(id);
      console.log(`send email verification to ${jenjang} ${nama_prodi}`);
    },
    onSendPasswordResetLink(id) {
      const {jenjang, nama_prodi} = this.getMemberById(id);
      console.log(`password reset link sent to ${jenjang} ${nama_prodi}`);
    },
    onDeactiveUser(id) {
      const {jenjang, nama_prodi} = this.getMemberById(id);
      console.log(`deactivate ${jenjang} ${nama_prodi}`);
    },
    getMemberById(id) {
      return this.members.find(member => member.id === id);
    },
    addDate,
  },
  created() {
    this.getUsers()
  },
}
</script>
