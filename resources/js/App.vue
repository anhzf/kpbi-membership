<template>
<v-app id="inspire">

    <DrawerNavigation :drawer="drawer"></DrawerNavigation>
    <NavigationBar @navigate="drawer = !drawer"></NavigationBar>

    <v-main>
        <keep-alive>
            <router-view v-if="$route.meta.keepAlive"></router-view>
        </keep-alive>
        <router-view v-if="!$route.meta.keepAlive"></router-view>
    </v-main>

    <PageFooter></PageFooter>

</v-app>
</template>

<script>
import DrawerNavigation from "./components/DrawerNavigation";
import PageFooter from "./components/PageFooter";
import NavigationBar from "./components/NavigationBar";

export default {
    data() {
        return {
            drawer: true
        }
    },


    components: {
        DrawerNavigation,
        NavigationBar,
        PageFooter,
    }
}
</script>
