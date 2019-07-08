<template>

    <!--toolbar-->
    <v-toolbar flat app>
        <v-toolbar-side-icon @click.stop="dtoggle"></v-toolbar-side-icon>
        <v-toolbar-title>Tech Admin</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down">
            <v-btn flat>Profile</v-btn>
            <v-btn flat>{{user.name}}.{{user.role}}</v-btn>
            <v-btn flat @click.prevent="logout">Logout</v-btn>
        </v-toolbar-items>
    </v-toolbar>
    <!--/toolbar-->
</template>

<script>
    export default {
        name: "Toolbar",
        data(){
            return{
                user: this.$store.state.currentUser,
            }
        },
        methods:{
            logout(){
                this.$store.commit('logout');
                this.$router.push('/login');
            },
            dtoggle(){
                this.$store.state.mini = !this.$store.state.mini;
            }
        }
    }
</script>

<style scoped>

</style>