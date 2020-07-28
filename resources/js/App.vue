<template>
<v-app>

    <DrawerNavigation
        :drawer="drawer"
        :isLoggedIn="isLoggedIn"
        :userEmail="userEmail"
        :userName="userName"
        @logout="logout"
    ></DrawerNavigation>
    <NavigationBar @navigate="drawer = !drawer" :contentLoading="isContentLoading"></NavigationBar>
    
    <div class="flash-alert__wrapper mx-sm-10 px-4 pt-4">
        <v-scale-transition group>
            <v-alert
                v-for="({message, color, type}, index) in flashes" :key="index"
                v-show="flashes[index].show"
                dismissible close-icon="mdi-close"
                :type="type" :color="color" border="left" elevation="20"
                colored-border
            ><span v-html="message"></span>
            </v-alert>
        </v-scale-transition>
    </div>

    <v-main>
        <keep-alive>
            <router-view
                :isLoading="isContentLoading"
                @contentLoading="isContentLoading = $event"
                @notice="flash"
                @login="login"
                @register="register"
            ></router-view>
        </keep-alive>
    </v-main>

</v-app>
</template>

<script>
import DrawerNavigation from "./components/DrawerNavigation";
// import PageFooter from "./components/PageFooter";
import NavigationBar from "./components/NavigationBar";
import authentication from "./util/authentication";
import hardRedirect from "./util/hardRedirect";

export default {
    data() {
        return {
            webToken: document.querySelector('meta[name=csrf-token]').content,
            drawer: true,
            isContentLoading: false,
            flashes: [],
            isLoggedIn: false,
            userId: null,
            userEmail: null,
            userName: null,
        }
    },


    methods: {
        async authenticate() {
            ({
                isLoggedIn: this.isLoggedIn,
                userId: this.userId,
                userEmail: this.userEmail,
                userName: this.userName,
            } = await authentication)
        },


        flash() {
            const flashes = [...arguments].map((
                    {
                        message, color = 'lime darken-1', type = undefined
                    }
                ) => {
                return {
                    show: true,
                    message, color, type
                }
            })

            this.flashes.push(...flashes)
        },

        
        login(data) {
            this.isContentLoading = true

            const loginData = {
                name: data.username,
                password: data.password,
                _token: this.webToken,
            }

            window.axios.post('/login', loginData)
                .then(({data}) => {
                    hardRedirect(this, {name: 'MyProfile'})
                    this.isContentLoading = false
                }).catch(err => {
                    this.axiosErrorMessageHandler(err)
                    this.isContentLoading = false
                })
        },


        logout() {
            this.isContentLoading = true

            window.axios.post('/logout')
                .then(() => {
                    hardRedirect(this, {name: 'Login'})
                    this.isContentLoading = false
                }).catch(err => this.axiosErrorMessageHandler(err))
        },


        register(data) {
            this.isContentLoading = true

            const registerData = {
                kaprodi: { email: data.email_kaprodi },
                email_prodi: data.email_prodi,
                jenjang: data.jenjang,
                nama_prodi: data.nama_prodi,
                pt: {
                    lengkap: data.pt.lengkap,
                    singkat: data.pt.singkat,
                },
                _token: this.webToken,
            }

            window.axios.post('/register', registerData)
                .then((data) => {
                    this.isContentLoading = false
                }).catch(err => this.axiosErrorMessageHandler(err))
        },


        axiosErrorMessageHandler() {
            const messages = [];
            [...arguments].forEach(({response: {data}}) => {
                if ('errors' in data) {
                    const errors = Object.entries(data.errors)
                    errors.forEach(([errType, errMsg]) => {
                        errMsg.forEach(msg => messages.push(`<b>${errType}:</b> ${msg}`))
                    })
                } else
                    messages.push(data.message)
            })
            messages.forEach(msg => this.flash({message: msg, type: 'error', color: 'red'}))
        }
    },


    created() {
        this.authenticate()
    },


    watch: {
        $route() {
            this.isContentLoading = false
        }
    },


    components: {
        DrawerNavigation,
        NavigationBar,
        // PageFooter,
    }
}
</script>


<style lang="scss" scoped>
.flash-alert {
    &__wrapper {
        position: fixed;
        z-index: 999;
        right: 0; bottom: 0;
        width: 100%; max-width: 1000px;
        max-height: 100vh;
        overflow-y: auto;
        background-color: #33691E10;

        &::-webkit-scrollbar {
            width: 5px;
            height: 5px;

            &-thumb {
                background-color: #b9b9b9;
                border-radius: 3px;
                &:hover { background-color: #ddd; }
            }
        }
    }
}
</style>