<template>
    <!--navigation drawer-->
    <v-navigation-drawer
            :mini-variant.sync="this.$store.state.mini"
            v-model="drawer"
            hide-overlay
            stateless
            app
    >
        <v-card class="ma-2 pa-2 text-md-center" flat>
            <v-avatar :size="piSize">
                <img src="/images/admin.png">
            </v-avatar>
        </v-card>

        <v-list>
            <v-list-tile
                    v-for="item in menus"
                    :key="item.title"
                    @click=""
            >
                <v-list-tile-action>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>
                        <router-link :to="{path: item.to}"><a>{{item.title}}</a></router-link>
                    </v-list-tile-title>
                </v-list-tile-content>

            </v-list-tile>
        </v-list>
    </v-navigation-drawer>
    <!--/navigation drawer-->
</template>

<script>
    export default {
        name: "NavDrawer",
        data(){
            return{
                drawer: true,
                user  : this.$store.state.currentUser,
                items : [
                    { icon: 'dashboard', title: 'Dashboard', to: '/'},
                    { icon: 'dashboard', title: 'User Management', to: '/user'},
                    { icon: 'dashboard', title: 'Role Management', to: '/user'},
                    { icon: 'dashboard', title: 'Attandance', to: '/user'},
                    { icon: 'dashboard', title: 'Profile', to: '/user'},
                    { icon: 'dashboard', title: 'College Information', to: '/user'},
                    { icon: 'dashboard', title: 'OCM', to: '/user'},
                ],
            }
        },
        computed: {

            piSize(){
                if(this.$store.state.mini){
                    return '48px';
                }
                else{
                    return '100px';
                }
            },

            menus(){
                switch(this.$store.state.currentUser.role){
                    case 'manager':
                        return [
                            { icon: 'dashboard', title: 'Dashboard', to: '/'},
                            { icon: 'dashboard', title: 'User Management', to: '/user'},
                            { icon: 'dashboard', title: 'Role Management', to: '/user'},
                            { icon: 'dashboard', title: 'Attandance', to: '/user'},
                            { icon: 'dashboard', title: 'Profile', to: '/user'},
                            { icon: 'dashboard', title: 'College Information', to: '/user'},
                            { icon: 'dashboard', title: 'OCM', to: '/user'},
                        ];
                        break;

                    case 'project co-ordinator':
                        return [
                            { icon: 'dashboard', title: 'Home', to: '/projcoord'},
                            { icon: 'dashboard', title: 'My Projects', to: '/projcoord/myprojects'},
                        ];
                        break;
                }
            }
        }
    }
</script>

<style scoped>

</style>