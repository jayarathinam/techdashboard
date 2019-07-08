<template>
    <v-app>
        <AuthLayout/>
        <v-content>
            <v-card class="ma-2 pa-2" flat color="background">
                <v-btn :to="{path: '/user/addUser'}">Add User</v-btn>

                <v-badge
                        overlap
                        color="orange"
                >
                    <span slot="badge" v-if="requestsLength">{{requestsLength}}</span>
                    <v-btn :to="{path: '/user/requests'}">
                        Requests
                    </v-btn>
                </v-badge>

                <v-badge
                        overlap
                        color="error"
                >
                    <span slot="badge" v-if="blockedUsersLength">{{blockedUsersLength}}</span>
                    <v-btn :to="{path: '/user/blocked-users'}">
                        Blocked
                    </v-btn>
                </v-badge>

            </v-card>
            <slot/>
        </v-content>
    </v-app>
</template>

<script>
    import AuthLayout from '../../Authenticated.vue'
    import { mapState } from 'vuex';

    export default {
        name: "UserManagement",
        components: {
            AuthLayout : AuthLayout
        },
        computed: {
            ...mapState(['blocked_users']),
            ...mapState(['requests']),
            blockedUsersLength(){
                return this.blocked_users.length;
            },
            requestsLength(){
                return this.requests.length;
            }
        },
        mounted() {
            this.$store.dispatch('fetchblockedusers');
            this.$store.dispatch('fetchrequests');
        }
    }
</script>

<style scoped>

</style>