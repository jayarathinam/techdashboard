<template>
    <v-container>
        <v-layout row>
            <v-flex xs12 sm5>

                <v-layout>
                    <v-flex md6>
                        <v-btn @click="downcsv()">
                            <v-icon>get_app</v-icon>
                            Sample CSV
                        </v-btn>
                    </v-flex>
                </v-layout>

                <v-card>

                    <template>
                        <v-progress-linear
                                v-if="loading"
                                :indeterminate="loading"
                                height="3px"
                        >
                        </v-progress-linear>
                        <div style="height: 3px; margin: 1rem" v-else></div>
                    </template>

                    <v-layout>
                        <v-flex xs8 offset-xs2>

                            <v-form ref="form">

                                <v-layout row>
                                    <v-flex md7>
                                        <v-text-field
                                                label="Upload user CSV"
                                                v-model="form.fileName"
                                                @click="pickFile()"
                                                :rules="inputRules"
                                                prepend-icon="file_copy"
                                        >
                                        </v-text-field>
                                        <input
                                                type="file"
                                                style="display:none"
                                                ref="file"
                                                accept=".csv"
                                                @change="onFilePicked"
                                        >
                                    </v-flex>
                                </v-layout>

                                <v-layout>
                                    <v-flex md6>
                                        <v-btn @click="addManyUsers()">Submit</v-btn>
                                    </v-flex>
                                    <v-flex md6>
                                        <v-btn @click="processUsersCSV()">Process</v-btn>
                                    </v-flex>
                                </v-layout>

                            </v-form>

                        </v-flex>
                    </v-layout>

                </v-card>

                <v-card class="mt-2 pa-1 red--text" style="word-wrap: break-word; text-align: justify">
                    <v-card-text v-if="current_error.length > 0" class="pb-0">{{current_error}}</v-card-text>
                    <v-card-text class="indigo--text">Note: Please Process your CSV For Better Error Results</v-card-text>
                </v-card>



            </v-flex>

            <v-flex xs12 sm6 offset-sm1>

            </v-flex>

        </v-layout>
    </v-container>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "addManyUser",
        data: () => ({

            form: {
                fileName : '',
                csvFile: '',
            },

            inputRules:[
                (v) => !!v || 'File is required'
            ]
        }),
        methods: {
            downcsv(){
                window.location.href = '/csv/sample.csv';
            },
            pickFile(){
                this.$refs.file.click();
            },
            onFilePicked(e){
                const files = e.target.files;
                if(files[0] !== undefined){
                    this.form.fileName = files[0].name;
                    //this.form.csvFile = files[0];
                    //alert(this.fileName);
                    const fr = new FileReader();
                    fr.readAsDataURL(files[0]);
                    fr.addEventListener('load', () => {
                        this.form.csvFile = fr.result;
                    });

                    //alert(this.form.fileName)
                }

                else{
                    this.form.fileName = '';
                    this.form.csvFile = '';
                }
            },

            addManyUsers(){
                if(this.$refs.form.validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('insertManyUsers', this.$data.form);
                }
            },

            processUsersCSV(){
                if(this.$refs.form.validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('processUsersCsv', this.$data.form);
                }
            }

        },

        computed:{
            ...mapState(['loading']),
            ...mapState(['current_error'])
        }
    }
</script>

<style scoped>

</style>