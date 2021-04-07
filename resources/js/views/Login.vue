<template>
  <v-container fluid class="fill-height">

    <v-row
      v-if="$route.query.message"
      justify="center"
    >
      <h5 class="text-h5">{{ $route.query.message }}</h5>
    </v-row>

    <v-row justify="center" align="stretch">

      <v-card width="320" class="elevation-4 mb-16">
        <v-form @submit.prevent="login">

          <v-card-title primary-title>
            <v-container fluid>
              <v-row>
                <v-img src="./img/ICON_KPBI.png" contain width="150" height="150"></v-img>
              </v-row>
              <v-row>
                <v-spacer></v-spacer>
              </v-row>
              <v-row justify="center" no-gutters>
                <span class="text-headline5">Login</span>
              </v-row>
            </v-container>
          </v-card-title>


          <v-card-text class="px-4">

            <v-text-field
              label="Username"
              placeholder="(ex. S2 PBIO UNS)"
              v-model="username"
              solo
            />
            <v-text-field
              :type="showPassword ? 'text' : 'password'"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
              label="Password"
              placeholder="password"
              v-model="password"
              solo
              @click:append="showPassword = !showPassword"
            />

          </v-card-text>

          <v-card-actions class="px-4">
            <div class="d-flex flex-column">
              <router-link :to="{ name: 'ForgotPassword' }" class="text-caption">Lupa password? klik disini</router-link>
              <router-link :to="{name: 'Register'}" class="text-caption">Daftar menjadi anggota</router-link>
            </div>
            <v-spacer></v-spacer>
            <v-btn type="submit" color="primary" text>Login</v-btn>
          </v-card-actions>

        </v-form>
      </v-card>

    </v-row>
  </v-container>
</template>

<script>
import {Login} from "@/util/Auth";

export default {
  name: 'Login',


  data() {
    return {
      showPassword: false,
      username: null,
      password: null,
    }
  },


  methods: {
    async login() {
      this.$store.commit('contentLoading', true)
      const loginData = {
        name: this.username,
        password: this.password,
      }
      try {
        await Login(loginData)
        this.$emit('notice', {message: 'Login Berhasil!', type: 'success'})
        this.$router.push(this.$route.query.redirect ??  {name: 'AccountSettings'})
      } catch (err) {
        this.$emit('noticeError', err)
      }
      this.$store.commit('contentLoading', false)
      this.$emit('contentLoading', false)
    }
  }
}
</script>
