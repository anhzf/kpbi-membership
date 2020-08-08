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
                        ></v-text-field>
                        <v-text-field
                            :type="showPassword ? 'text' : 'password'"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            label="Password"
                            placeholder="password"
                            v-model="password"
                            solo
                            @click:append="showPassword = !showPassword"
                        ></v-text-field>

                    </v-card-text>

                    <v-card-actions class="px-4">
                        <router-link :to="{name: 'Register'}" class="text-caption">Daftar menjadi anggota</router-link>
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
            // Set page state to Loading
            this.$store.commit('contentLoading', true)
            const loginData = {
                name: this.username,
                password: this.password,
            }
            const login = await Login(loginData)

            // Set page state to finished Loading
            this.$store.commit('contentLoading', false)
            this.$emit('contentLoading', false)
            if (login.success) {
                // Notice to User
                this.$emit('notice', {message: 'Login Berhasil!', type: 'success'})
                // Redirect user
                this.$router.push(this.$route.query.redirect ??  {name: 'AccountSettings'})
            } else {
                this.$emit('noticeError', login)
            }
        }
    }
}
</script>