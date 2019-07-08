<template>
    <v-card color="mback" flat>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card class="ma-4 pa-2" flat v-for="(item, index) in projectDetails" :key="item.id">
                    <!--<h3>{{item.additionalcontents}}</h3>-->

                    <v-btn color="black" dark @click="openAACDialog()">
                        <v-icon dark left>library_add</v-icon>Add Additional Content
                    </v-btn>

                    <v-layout row justify-center>
                        <v-dialog
                                v-model="aacdialog"
                                persistent
                                max-width="500"
                        >
                            <v-card>

                                <v-card-title>
                                    <span class="headline">Add Additional Content</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-form :ref="`aacform${item.id}`" v-model="valid" lazy-validation>
                                            <v-layout wrap>

                                                <v-flex xs6 sm7 md7>

                                                    <v-text-field
                                                            v-model="aacform.title"
                                                            label="Title"
                                                            :rules="aacRules"
                                                            required>
                                                    </v-text-field>

                                                    <v-textarea
                                                            v-model="aacform.acontent"
                                                            label="Content"
                                                            :rules="aacRules"
                                                            auto-grow
                                                    ></v-textarea>


                                                </v-flex>

                                                <v-flex xs6 sm5 md5>

                                                </v-flex>

                                            </v-layout>
                                        </v-form>
                                    </v-container>
                                </v-card-text>


                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" flat @click="aacdialog = false">Close</v-btn>
                                    <v-btn color="blue darken-1" flat @click="aacsubmit(`aacform${item.id}`, item.id)">Add</v-btn>
                                </v-card-actions>

                            </v-card>
                        </v-dialog>
                    </v-layout>

                    <v-layout row wrap>
                        <v-flex xs6 v-for="(itemd, index) in item.additionalcontents" :key="item.id">
                            <v-card flat class="border-success ml-2 mr-2">
                                <v-toolbar color="cyan" dark flat>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>

                                    <v-toolbar-title>{{ itemd.title }}</v-toolbar-title>


                                    <v-spacer></v-spacer>

                                    <v-btn icon>
                                        <v-icon @click="openAACPUDialog(itemd.id, itemd.titleplace, itemd.content_type)">loop</v-icon>
                                    </v-btn>

                                    <v-btn icon>
                                        <v-icon @click="openAACUDialog(itemd.id, itemd.title, itemd.content)">edit</v-icon>
                                    </v-btn>

                                    <v-btn icon>
                                        <v-icon @click="acDelete(itemd.id)">delete</v-icon>
                                    </v-btn>

                                </v-toolbar>


                                <v-card-text>
                                    <div v-for="(itemacon, index) in itemd.content">
                                       <p class="subheading text-xs-justify">{{itemacon}}</p>
                                    </div>
                                </v-card-text>

                                <v-layout row justify-center>
                                <v-dialog
                                        v-model="aacudialog == itemd.id? true: false"
                                        persistent
                                        max-width="500"
                                >
                                    <v-card>

                                        <v-card-title>
                                            <span class="headline">Edit Additional Content</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container grid-list-md>
                                                <v-form :ref="`aacuform${itemd.id}`" v-model="valid" lazy-validation>
                                                    <v-layout wrap>

                                                        <v-flex xs6 sm7 md7>

                                                            <v-text-field
                                                                    v-model="aacuform.title"
                                                                    label="Title"
                                                                    :rules="aacuRules"
                                                                    required>
                                                            </v-text-field>

                                                            <v-textarea
                                                                    v-model="aacuform.acontent"
                                                                    label="Content"
                                                                    :rules="aacuRules"
                                                                    auto-grow
                                                            ></v-textarea>


                                                        </v-flex>

                                                        <v-flex xs6 sm5 md5>

                                                        </v-flex>

                                                    </v-layout>
                                                </v-form>
                                            </v-container>
                                        </v-card-text>


                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" flat @click="aacudialog = false">Close</v-btn>
                                            <v-btn color="blue darken-1" flat @click="aacusubmit(`aacuform${itemd.id}`, itemd.id)">Update</v-btn>
                                        </v-card-actions>

                                    </v-card>
                                </v-dialog>
                            </v-layout>

                                <v-layout row justify-center>
                                    <v-dialog
                                            v-model="aacpudialog == itemd.id? true: false"
                                            persistent
                                            max-width="500"
                                    >
                                        <v-card>

                                            <v-card-title>
                                                <span class="headline">Edit Additional Content</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container grid-list-md>
                                                    <v-form :ref="`aacpuform${itemd.id}`" v-model="valid" lazy-validation>
                                                        <v-layout wrap>

                                                            <v-flex xs6 sm7 md7>

                                                                <v-text-field
                                                                        v-model="aacpuform.tplace"
                                                                        label="Title"
                                                                        :rules="aacpuRules"
                                                                        required>
                                                                </v-text-field>

                                                                <v-text-field
                                                                        v-model="aacpuform.ctype"
                                                                        label="Title"
                                                                        :rules="aacpuRules"
                                                                        required>
                                                                </v-text-field>

                                                            </v-flex>

                                                            <v-flex xs6 sm5 md5>

                                                            </v-flex>

                                                        </v-layout>
                                                    </v-form>
                                                </v-container>
                                            </v-card-text>


                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" flat @click="aacpudialog = false">Close</v-btn>
                                                <v-btn color="blue darken-1" flat @click="aacpusubmit(`aacpuform${itemd.id}`, itemd.id)">Update</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-dialog>
                                </v-layout>

                            </v-card>
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
        name: "addCont",
        data: () => {
          return {
              id: 0,
              valid: false,
              aacdialog: false,
              aacudialog: false,
              aacpudialog: false,
              aacform: {
                  title: '',
                  acontent: ''
              },
              aacuform:{
                  title:'',
                  acontent: ''
              },
              aacpuform:{
                  tplace:'',
                  ctype: ''
              },
              aacRules: [
                  (v) => !!v || 'This Field is Required'
              ],
              aacuRules: [
                  (v) => !!v || 'This Field is Required'
              ],
              aacpuRules: [
                  (v) => !!v || 'This Field is Required'
              ],
          }
        },
        created(){
            this.id = this.$route.params.id;
        },
        mounted(){
            this.$store.dispatch('fetchProjdetails', this.id);
        },
        methods:{
            openAACDialog(){
                this.aacdialog = true;
            },
            openAACUDialog(cid, title, content){
                this.aacudialog = cid;
                this.aacuform.title = title;
                this.aacuform.acontent = content;
            },
            openAACPUDialog(cid, tplace, ctype){
                this.aacpudialog = cid;
                this.aacpuform.tplace = tplace;
                this.aacpuform.ctype = ctype;
            },
            aacsubmit(form){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('addAContent', {id: this.id, formData: this.$data.aacform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.aacdialog = false;
                }
            },
            aacusubmit(form, acid){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('updateAContent', {id: this.id, acid, formData: this.$data.aacuform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.aacudialog = false;
                }
            },
            aacpusubmit(form, acid){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('updateACPriority', {id: this.id, acid, formData: this.$data.aacpuform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.aacpudialog = false;
                }
            },
            acDelete(acid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteAContent', {acid, id: this.id});
            },
        },
        computed:{
            ...mapState(['projectDetails']),
        }
    }
</script>

<style scoped>

</style>