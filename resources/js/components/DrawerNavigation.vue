<template>
	<v-navigation-drawer
    :value="value"
    @input="$emit('input', $event)"
    app
    class="elevation2"
  >
		<v-system-bar color="light-green lighten-2" />

		<v-list>
			<v-list-item>
				<v-list-item-avatar>
					<v-img src="./img/ICON_KPBI.png" />
				</v-list-item-avatar>
				<v-list-item-content v-if="!isLoggedIn">
					<v-list-item-title>KPBI</v-list-item-title>
				</v-list-item-content>
			</v-list-item>

			<v-list-item v-if="isLoggedIn">
				<v-list-item-content>
					<v-list-item-title class="title">
            {{ userName }}
          </v-list-item-title>
					<v-list-item-subtitle>
            {{ userEmail }}
          </v-list-item-subtitle>
				</v-list-item-content>
			</v-list-item>
		</v-list>

		<v-divider />

		<v-list dense>
      <template v-if="isLoggedIn">
        <v-list-item
          :to="{name: 'MyProfile'}"
          link
        >
          <v-list-item-action>
            <v-icon>mdi-account</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Profil Saya</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item
          :to="{name: 'AccountSettings'}"
          link
        >
          <v-list-item-action>
            <v-icon>mdi-settings</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Pengaturan Akun</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </template>

      <template v-else>
        <v-list-item
          :to="{name: 'Login'}"
          link
        >
          <v-list-item-action>
            <v-icon>mdi-login-variant</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Login</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item
          :to="{name: 'Register'}"
          link
        >
          <v-list-item-action>
            <v-icon>mdi-account-plus</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Register</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </template>

			<v-list-item
        v-if="userRole === 'admin'"
        :to="{name: 'Admin'}"
        link
      >
				<v-list-item-action>
					<v-icon>mdi-shield-account</v-icon>
				</v-list-item-action>
				<v-list-item-content>
					<v-list-item-title>Admin</v-list-item-title>
				</v-list-item-content>
			</v-list-item>

			<v-list-item
        v-if="isLoggedIn"
        @click.stop="logout"
      >
				<v-list-item-action>
					<v-icon>mdi-exit-to-app</v-icon>
				</v-list-item-action>
				<v-list-item-content>
					<v-list-item-title>Logout</v-list-item-title>
				</v-list-item-content>
			</v-list-item>

			<v-divider />

			<v-list-item
        :to="{name: 'Members'}"
        link
      >
				<v-list-item-action>
					<v-icon>mdi-account-multiple</v-icon>
				</v-list-item-action>
				<v-list-item-content>
					<v-list-item-title>Anggota KPBI</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
		</v-list>
	</v-navigation-drawer>
</template>

<script>
import { Logout } from "@/util/Auth";
import { mapGetters } from "vuex";

export default {
	name: "DrawerNavigation",

	props: {
		value: Boolean,
		drawer: Boolean,
		// isLoggedIn: Boolean,
		// userName: {
		// 	type: String,
		// 	required: false,
		// },
		// userEmail: {
		// 	type: String,
		// 	required: false,
		// },
	},

	computed: {
    ...mapGetters([
      'isLoggedIn',
      'userEmail',
      'userName',
      'userRole',
    ])
  },

	methods: {
		async logout() {
			this.$store.commit("contentLoading", true);
			const logout = await Logout();
			if (logout.success) {
				this.$emit("notice", { message: "Berhasil Log Out!" });
				this.$router.push({ name: "Login" });
			}
			this.$store.commit("contentLoading", false);
		},
	},
};
</script>
