<template>
    <v-card flat color="background" class="ma-4">

        <v-layout row wrap>
            <v-flex xs4>
                <v-card color="#26c6da" class="white--text ml-1 mr-1" flat :to="{path: '/projcoord/myprojects/'+id+'/confedit'}">
                    <v-card-text primary-title>
                        <div>
                            <div class="headline font-weight-bold text-xs-center">
                                    Conference Details
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs4>
                <v-card color="#26c6da" class="white--text ml-1 mr-1" flat :to="{path: '/projcoord/myprojects/'+id+'/cms'}">
                    <v-card-text primary-title>
                        <div>
                            <div class="headline font-weight-bold text-xs-center">
                                OCM Details
                            </div>
                            <span></span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs4>
                <v-card color="#26c6da" class="white--text ml-1 mr-1" flat :to="{path: '/projcoord/myprojects/'+id+'/confreg'}">
                    <v-card-text primary-title>
                        <div>
                            <div class="headline font-weight-bold text-xs-center">
                                Registration Details
                            </div>
                            <span></span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap class="mt-3">
            <v-flex xs4>
                <v-card color="#26c6da" class="white--text ml-1 mr-1" flat :to="{path: '/projcoord/myprojects/'+id+'/addcontedit'}">
                    <v-card-text primary-title>
                        <div>
                            <div class="headline font-weight-bold text-xs-center">
                                Additional Content Details
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs4>
                <v-card color="#26c6da" class="white--text ml-1 mr-1" flat :to="{path: '/projcoord/myprojects/'+id+'/galleryedit'}">
                    <v-card-text primary-title>
                        <div>
                            <div class="headline font-weight-bold text-xs-center">
                                Gallery Details
                            </div>
                            <span></span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-flex>

          <!--  <v-flex xs4>
                <v-card color="#26c6da" class="white--text ml-1 mr-1" flat :to="{path: '/projcoord/myprojects/'+id+'/confreg'}">
                    <v-card-text primary-title>
                        <div>
                            <div class="headline font-weight-bold text-xs-center">
                                Registration Details
                            </div>
                            <span></span>
                        </div>
                    </v-card-text>
                </v-card>
            </v-flex>-->
        </v-layout>

    </v-card>
</template>

<script>
    export default {
        name: "cmsmenu",
        data: () => {
            return {
                id: 0
            }
        },
        created(){
            this.id = this.$route.params.id;
        },
    }
</script>

<style scoped>

</style>