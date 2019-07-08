<template>
    <v-card flat class="ma-4 pa-2" color="mback" >
        <!--<h3>{{projectDetails}}</h3>-->
        <!--<h3>{{ocm}}</h3>-->

        <v-layout row wrap>
            <v-flex class="xs12">
                <v-card flat class="ma-2 pa-2">
                    <v-btn color="dbluebutton" class="white--text" @click="cms(projectDetails[0].id)">{{projectDetails[0].name}} CMS</v-btn>

                    <!--<v-badge
                            overlap
                            color="orange"
                    >
                        <span slot="badge"></span>
                        <v-btn :to="{path: '/user/requests'}">
                            Requests
                        </v-btn>
                    </v-badge>-->

                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap>
            <v-flex class="xs12">
                <v-card flat class="ma-2 pa-2">

                    <v-layout row class="mb-4">
                        <v-flex clas="xs12">
                            <h1>{{projectDetails[0].fullname}}-({{projectDetails[0].name}})</h1>
                        </v-flex>
                    </v-layout>

                    <v-layout row>
                        <v-flex class="xs4 ma-2">
                            <h2 class="mb-2 stitle--text">Basic Informations</h2>
                            <h3>{{projectDetails[0].type}} conference</h3>
                            <h3>{{projectDetails[0].sdate}}</h3>
                            <h3>{{projectDetails[0].venue}}</h3>
                        </v-flex>

                        <v-flex class="xs4 ma-2">
                            <h2 class="mb-2 stitle--text">Important Dates</h2>

                            <div v-for="impdate in projectDetails[0].impdates">
                                <h3>{{impdate['idatemenu'].idatemenu}}</h3>
                                <p>{{impdate.impdate}}</p>
                            </div>

                        </v-flex>

                        <v-flex class="xs4 ma-2">
                            <h2 class="mb-2 stitle--text">Venue</h2>
                            <h3>{{projectDetails[0].venue}}</h3>
                        </v-flex>

                    </v-layout>

                </v-card>
            </v-flex>
        </v-layout>
    </v-card>
</template>

<script>
    import {mapState} from 'vuex';
    import VContent from "vuetify/lib/components/VGrid/VContent";

    export default {
        name: "projectDetails",
        components: {VContent},
        data: () => {
            return {
                id: 0
            }
        },
        created(){
            this.id = this.$route.params.id;
        },
        mounted(){
            this.$store.dispatch('fetchProjdetails', this.id);
            this.$store.dispatch('fetchOcmdetails', this.id);
        },
        computed:{
            ...mapState(['projectDetails']),
                ...mapState(['ocm'])
        },
        methods:{
            cms(prId)
            {
                this.$router.push({path: '/projcoord/myprojects/'+prId+'/cmsmenu'});
            }
        }
    }
</script>

<style scoped>

</style>