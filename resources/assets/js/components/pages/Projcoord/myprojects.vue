<template>
        <v-card flat color="background" class="ma-4">
                <v-layout row wrap>
                        <v-flex md-12>
                                <v-card class="ma-2 pa-2" flat>
                                        <!--<img src="/images/folder.jpg" width="80">-->
                                        <v-layout row wrap>
                                                <v-flex md2 v-for="project in projectbyUser" :key="project.id">
                                                        <img src="/images/folder.jpg" width="80" class="ml-2">
                                                        <div>
                                                                <v-btn depressed small @click="projdetail(project.id)">{{ project.name }}</v-btn>
                                                        </div>
                                                </v-flex>
                                        </v-layout>
                                </v-card>
                        </v-flex>
                </v-layout>
        </v-card>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "myprojects",
        mounted(){
            this.$store.dispatch('fetchProjectsbyUser', this.$store.state.currentUser.id);
        },
        methods:{
             projdetail(projectId)
             {
                 //alert(projectId);
                 //this.$store.dispatch('fetchProjdetails', projectId);
                 this.$router.push({path: '/projcoord/myprojects/'+projectId})
             }
        },
        computed: {
            ...mapState(['projectbyUser'])
        }
    }
</script>

<style scoped>

</style>