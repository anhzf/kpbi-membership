<template>
  <v-container fluid class="fill-height">

    <v-row justify="center" align="stretch">

      <v-card width="100%" max-width="650" class="elevation-4 mb-16">
        <v-form @submit.prevent="register">

          <v-card-title primary-title>Daftar Anggota</v-card-title>

          <v-divider></v-divider>

          <v-card-text class="px-2 px-sm-10">

            <v-select
              v-model="jenjang" :rules="[requiredRules]" required
              label="Jenjang"
              :items="['S1','S2','S3']"
              outlined
            ></v-select>
            <v-text-field
              v-model="nama_prodi" :rules="[requiredRules]" required
              label="Nama Prodi"
              outlined
            ></v-text-field>
            <v-text-field
              v-model="pt.lengkap" :rules="[requiredRules]" required
              label="Nama Perguruan Tinggi (Lengkap)"
              outlined
            ></v-text-field>
            <v-text-field
              v-model="pt.singkat" :rules="[requiredRules]" required
              label="Nama Perguruan Tinggi (Singkat)"
              outlined
            ></v-text-field>
            <v-text-field
              v-model="email_prodi" :rules="[requiredRules, emailRules]" required
              label="Email Prodi"
              type="email"
              outlined
            ></v-text-field>
            <v-text-field
              v-model="email_kaprodi" :rules="[requiredRules, emailRules]" required
              label="Email Kaprodi"
              type="email"
              outlined
            ></v-text-field>

          </v-card-text>

          <v-card-actions class="px-4">
            <router-link :to="{name: 'Login'}" class="text-caption">Sudah punya akun ? Klik disini untuk Login</router-link>
            <v-spacer></v-spacer>
            <v-btn type="submit" color="primary" text>Daftar</v-btn>
          </v-card-actions>

        </v-form>
      </v-card>

    </v-row>
  </v-container>
</template>

<script>
import { Register } from '@/util/Auth'
import { required as requiredRules, email as emailRules } from "@/util/Validator";

export default {
  name: 'Register',
  data() {
    return {
      jenjang: null,
      nama_prodi: null,
      pt: {
        lengkap: null,
        singkat: null,
      },
      email_prodi: null,
      email_kaprodi: null,
      requiredRules, emailRules
    }
  },
  methods: {
    async register() {
      this.$store.commit('contentLoading', true)

      const registerData = {
        kaprodi: { email: this.email_kaprodi },
        email_prodi: this.email_prodi,
        jenjang: this.jenjang,
        nama_prodi: this.nama_prodi,
        pt: {
          lengkap: this.pt.lengkap,
          singkat: this.pt.singkat,
        },
      }

      const register = await Register(registerData)
      // Set page state to finished Loading
      this.$store.commit('contentLoading', false)
      console.log(register)
      if (register.success) {
        // Notice to User
        this.$emit('notice', {message: register.message, type: 'success'})
        this.$emit('notice', {message: 'Silahkan coba login untuk melanjutkan'})
        // Redirect user
        this.$router.push({name: 'Login'})
      } else {
        this.$emit('noticeError', register)
      }
    },
  }
}
</script>
