<template>
    <v-container>
        <v-layout>
            <v-flex xs12>
                <v-layout>

                    <v-flex xs3>
                        <v-card flat class="pa-3 text-md-center">
                            <v-avatar size="150">
                                <img :src="user_details[0].pimg">
                            </v-avatar>
                            <v-list two-line subheader>

                                <v-list-tile>

                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ user_details[0].name }}</v-list-tile-title>
                                        <v-list-tile-sub-title>Name</v-list-tile-sub-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-btn fab dark small color="cyan" flat>
                                            <v-icon dark>edit</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>

                                <v-list-tile>

                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ user_details[0].gender }}</v-list-tile-title>
                                        <v-list-tile-sub-title>Gender</v-list-tile-sub-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-btn fab dark small color="cyan" flat>
                                            <v-icon dark>edit</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>

                                <v-list-tile>

                                   <v-list-tile-content>
                                    <v-list-tile-title>{{ user_details[0].dob }}</v-list-tile-title>
                                    <v-list-tile-sub-title>Date of Birth</v-list-tile-sub-title>
                                   </v-list-tile-content>

                                  <v-list-tile-action>
                                      <v-btn fab dark small color="cyan" flat>
                                          <v-icon dark>edit</v-icon>
                                      </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>

                                <v-list-tile>

                                <v-list-tile-content>
                                    <v-list-tile-title>{{ user_details[0].role }}</v-list-tile-title>
                                    <v-list-tile-sub-title>Role</v-list-tile-sub-title>
                                </v-list-tile-content>

                                <v-list-tile-action>
                                    <v-btn fab dark small color="cyan" flat>
                                        <v-icon dark>edit</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>

                                <v-list-tile>

                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ user_details[0].email }}</v-list-tile-title>
                                        <v-list-tile-sub-title>Email</v-list-tile-sub-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-btn fab dark small color="cyan" flat>
                                            <v-icon dark>edit</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>

                                <v-list-tile>

                                    <v-list-tile-content>
                                        <v-list-tile-title>{{ user_details[0].auth }}</v-list-tile-title>
                                        <v-list-tile-sub-title>Status</v-list-tile-sub-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>

                                    </v-list-tile-action>
                                </v-list-tile>


                            </v-list>
                        </v-card>
                    </v-flex>

                    <v-flex xs9>
                    </v-flex>

                </v-layout>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "userDetails",
        data:() => {
            return{
                id: 0
            }
        },
        mounted(){
            this.$store.dispatch('userDetails', this.id);
        },
        created(){
            this.id = this.$route.params.id;
        },
        computed:{
            ...mapState(['user_details'])
        }
    }
</script>

<style scoped>

</style>