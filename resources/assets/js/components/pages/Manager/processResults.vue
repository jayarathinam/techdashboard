<template>
    <v-container>
        <v-layout>
            <v-flex>

                <v-btn :to="{path: '/user/addManyUser'}" class="mb-3">Back</v-btn>

                <v-data-table
                        :headers="headers"
                        :items="csvError"
                        class="elevation-1"
                        v-if="csvError.indexOf('success') == -1 && csvError.indexOf('csvwrong') && csvError.indexOf('unknownerr')"
                >
                    <template slot="items" slot-scope="props">
                        <td>{{ props.item.duplicate_email }}</td>
                    </template>
                </v-data-table>


                <v-card v-else-if="csvError.indexOf('success') != -1" class="pa-3">

                    <v-list>
                        <v-list-tile avatar>
                            <v-list-tile-avatar>
                                <v-icon large color="success">check_circle</v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title class="green--text">
                                    <h3>Your CSV File is Processed Successfully...!, and Ready to upload </h3>
                                </v-list-tile-title>
                            </v-list-tile-content>

                        </v-list-tile>
                    </v-list>
                </v-card>

                <v-card v-else-if="csvError.indexOf('csvwrong') != -1 || csvError.indexOf('unknownerr') != -1" class="pa-3">
                    <h3 class="red--text" v-if="csvError.indexOf('csvwrong') != -1">
                        The CSV File that you provided is wrong.
                        <v-btn @click="downcsv()">
                            <v-icon>get_app</v-icon>
                            Sample CSV
                        </v-btn>
                    </h3>
                    <h3 class="red--text" v-if="csvError.indexOf('unknownerr') != -1">Sorry.., The Error is Unknown</h3>
                </v-card>

            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapState} from  'vuex';

    export default {
        name: "processResults",
        data:() => {
            return{
                headers:[
                    { text: 'Email(Already Registered)', value: 'duplicate email' },
                ]
            }
        },
        computed: {
            ...mapState(['csvError']),
            ...mapState(['current_error'])
        },

        methods:{
            redirect(){
                if(this.csvError.length == 0){
                    this.$router.push('/user/addManyUser');
                }
            }
        },

        beforeMount(){
            this.redirect();
        }
    }
</script>

<style scoped>

</style>