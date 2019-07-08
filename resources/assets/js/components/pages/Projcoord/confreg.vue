<template>
  <v-card flat color="mback">
    <v-layout row wrap>
      <v-flex xs12>
        <v-card class="ma-4 pa-2" flat v-for="regd in regDetails.regs" :key="regd.id">

          <v-btn color="black" dark @click="openMDialog()">
            <v-icon dark left>library_add</v-icon>Add Menu
          </v-btn>

          <v-layout row justify-center>
            <v-dialog
                    v-model="mdialog"
                    persistent
                    max-width="500"
            >
              <v-card>

                <v-card-title>
                  <span class="headline">Add Menu</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-form :ref="mform" v-model="valid" lazy-validation>
                      <v-layout wrap>

                        <v-flex xs6 sm7 md7>
                          <v-text-field
                                  v-model="mform.regmenu"
                                  :rules="mRules"
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
                  <v-btn color="blue darken-1" flat @click="mdialog = false">Close</v-btn>
                  <v-btn color="blue darken-1" flat @click="msubmit(mform)">Add</v-btn>
                </v-card-actions>

              </v-card>
            </v-dialog>
          </v-layout>

          <v-layout row wrap>
            <v-flex>

              <v-card flat class="border-success ml-2 mr-2" v-for="regmenus in regd.regmenus" :key="regmenus.id">

                <v-toolbar color="cyan" dark flat>

                  <!--<v-toolbar-side-icon></v-toolbar-side-icon>-->

                  <v-toolbar-title>{{regmenus.regmenu }}</v-toolbar-title>

                  <v-spacer></v-spacer>

                  <v-btn icon>
                    <v-icon  @click="opensMDialog(regmenus.id)">library_add</v-icon>
                  </v-btn>

                  <v-btn icon>
                    <v-icon @click="openeMDialog(regmenus.id, regmenus.regmenu)">edit</v-icon>
                  </v-btn>

                  <v-btn icon>
                    <v-icon @click="rmDelete(regmenus.id)">delete</v-icon>
                  </v-btn>

                </v-toolbar>

                <v-layout row justify-center>
                  <v-dialog
                          v-model="smdialog == regmenus.id? true : false"
                          persistent
                          max-width="500"
                  >
                    <v-card>

                      <v-card-title>
                        <span class="headline">Add Submenu</span>
                      </v-card-title>

                      <v-card-text>
                        <v-container grid-list-md>
                          <v-form :ref="`smform${regmenus.id}`" v-model="valid" lazy-validation>
                            <v-layout wrap>

                              <v-flex xs6 sm7 md7>
                                <v-text-field
                                        v-model="smform.regsmenu"
                                        :rules="smRules"
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
                        <v-btn color="blue darken-1" flat @click="smdialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" flat @click="smsubmit(`smform${regmenus.id}`, regmenus.id)">Add</v-btn>
                      </v-card-actions>

                    </v-card>
                  </v-dialog>
                </v-layout>

                <v-layout row justify-center>
                  <v-dialog
                          v-model="emdialog == regmenus.id? true : false"
                          persistent
                          max-width="500"
                  >
                    <v-card>

                      <v-card-title>
                        <span class="headline">Edit Menu</span>
                      </v-card-title>

                      <v-card-text>
                        <v-container grid-list-md>
                          <v-form :ref="`emform${regmenus.id}`" v-model="valid" lazy-validation>
                            <v-layout wrap>

                              <v-flex xs6 sm7 md7>
                                <v-text-field
                                        v-model="emform.regmenu"
                                        :rules="emRules"
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
                        <v-btn color="blue darken-1" flat @click="emdialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" flat @click="emsubmit(`emform${regmenus.id}`, regmenus.id)">Update</v-btn>
                      </v-card-actions>

                    </v-card>
                  </v-dialog>
                </v-layout>

                <v-card-text>
                  <div>
                    <!--<div class="mb-4">{{regmenus.regmenu }}</div>-->
                    <v-btn color="black" dark @click="openCurdialog(regmenus.id)">
                      <v-icon dark left>library_add</v-icon>Add Currency type
                    </v-btn>

                    <v-btn color="black" dark @click="openRTdialog(regmenus.id)" :disabled="regmenus.regtypes.length === 0">
                      <v-icon dark left>library_add</v-icon>Add Registration type
                    </v-btn>

                    <v-layout row justify-center>
                      <v-dialog
                              v-model="curdialog == regmenus.id? true : false"
                              persistent
                              max-width="500"
                      >
                        <v-card>

                          <v-card-title>
                            <span class="headline">Add Currency Type</span>
                          </v-card-title>

                          <v-card-text>
                            <v-container grid-list-md>
                              <v-form :ref="`curform${regmenus.id}`" v-model="valid" lazy-validation>
                                <v-layout wrap>

                                  <v-flex xs6 sm7 md7>
                                    <v-text-field
                                            v-model="curform.curtype"
                                            :rules="curRules"
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
                            <v-btn color="blue darken-1" flat @click="curdialog = false">Close</v-btn>
                            <v-btn color="blue darken-1" flat @click="cursubmit(`curform${regmenus.id}`, regmenus.id)">Add</v-btn>
                          </v-card-actions>

                        </v-card>
                      </v-dialog>
                    </v-layout>

                    <v-layout row justify-center>
                      <v-dialog
                              v-model="rtdialog == regmenus.id? true : false"
                              persistent
                              max-width="500"
                      >
                        <v-card>

                          <v-card-title>
                            <span class="headline">Add Registration Type</span>
                          </v-card-title>

                          <v-card-text>
                            <v-container grid-list-md>
                              <v-form :ref="`rtform${regmenus.id}`" v-model="valid" lazy-validation>
                                <v-layout wrap>

                                  <v-flex xs6 sm7 md7>

                                    <v-text-field
                                            v-model="rtform.regtype"
                                            :rules="rtRules"
                                            required>
                                    </v-text-field>

                                    <v-menu
                                            :close-on-content-click="false"
                                            v-model="regdmenu"
                                            lazy
                                    >
                                      <v-text-field
                                              slot="activator"
                                              v-model="rtform.regdate"
                                              :rules="rtRules"
                                              label="Date"
                                              append-icon="event"
                                              readonly
                                      ></v-text-field>
                                      <v-date-picker v-model="rtform.regdate" @input="regdmenu = false"></v-date-picker>
                                    </v-menu>

                                  </v-flex>

                                  <v-flex xs6 sm5 md5>

                                  </v-flex>

                                </v-layout>
                              </v-form>
                            </v-container>
                          </v-card-text>


                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click="rtdialog = false">Close</v-btn>
                            <v-btn color="blue darken-1" flat @click="rtsubmit(`rtform${regmenus.id}`, regmenus.id)">Add</v-btn>
                          </v-card-actions>

                        </v-card>
                      </v-dialog>
                    </v-layout>

                    <table v-for="regsmenus in regmenus.regsmenus">
                      <v-card flat>
                        <v-toolbar color="yellow" dark flat>
                          <v-toolbar-side-icon class="black--text"></v-toolbar-side-icon>

                          <v-toolbar-title class="black--text">{{regsmenus.regsubmenu}}</v-toolbar-title>

                          <v-spacer></v-spacer>

                          <v-btn icon>
                            <v-icon class="black--text" @click="openrsMDialog(regsmenus.id, regsmenus.regsubmenu)">edit</v-icon>
                          </v-btn>

                          <v-btn icon>
                            <v-icon class="black--text" @click="rsmDelete(regsmenus.id)">delete</v-icon>
                          </v-btn>
                        </v-toolbar>

                        <v-layout row justify-center>
                          <v-dialog
                                  v-model="rsmdialog == regsmenus.id? true : false"
                                  persistent
                                  max-width="500"
                          >
                            <v-card>

                              <v-card-title>
                                <span class="headline">Edit Submenu</span>
                              </v-card-title>

                              <v-card-text>
                                <v-container grid-list-md>
                                  <v-form :ref="`rsmform${regsmenus.id}`" v-model="valid" lazy-validation>
                                    <v-layout wrap>

                                      <v-flex xs6 sm7 md7>

                                        <v-text-field
                                                v-model="rsmform.regsmenu"
                                                :rules="rsmRules"
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
                                <v-btn color="blue darken-1" flat @click="rsmdialog = false">Close</v-btn>
                                <v-btn color="blue darken-1" flat @click="rsmsubmit(`rsmform${regsmenus.id}`, regsmenus.id)">Update</v-btn>
                              </v-card-actions>

                            </v-card>
                          </v-dialog>
                        </v-layout>

                        <v-card-text>
                          <v-btn color="black" dark  @click="openCdialog(regsmenus.id)">
                            <v-icon dark left>library_add</v-icon>Add Category
                          </v-btn>

                          <v-layout row justify-center>
                            <v-dialog
                                    v-model="cdialog == regsmenus.id? true : false"
                                    persistent
                                    max-width="500"
                            >
                              <v-card>

                                <v-card-title>
                                  <span class="headline">Add Category</span>
                                </v-card-title>

                                <v-card-text>
                                  <v-container grid-list-md>
                                    <v-form :ref="`cform${regsmenus.id}`" v-model="valid" lazy-validation>
                                      <v-layout wrap>

                                        <v-flex xs6 sm7 md7>

                                          <v-text-field
                                                  v-model="cform.category"
                                                  :rules="cRules"
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
                                  <v-btn color="blue darken-1" flat @click="cdialog = false">Close</v-btn>
                                  <v-btn color="blue darken-1" flat @click="csubmit(`cform${regsmenus.id}`, regsmenus.id, regmenus.id)">Add</v-btn>
                                </v-card-actions>

                              </v-card>
                            </v-dialog>
                          </v-layout>

                          <tr>
                            <td class="subheading font-weight-bold">Actions</td>
                            <td class="subheading font-weight-bold">Categories</td>
                            <td v-for="regtypes in regmenus.regtypes" class="subheading font-weight-bold">
                                <p>{{regtypes.reg_type}} ({{regtypes.currency_type}}) </p>
                                <p>({{regtypes.reg_type_date}})</p>
                            </td>
                          </tr>

                          <tr>
                            <td colspan="2"></td>
                            <td v-for="regtypes in regmenus.regtypes">
                              <v-btn icon>
                                <v-icon @click="rtCDelete(regtypes.id)">delete</v-icon>
                              </v-btn>
                              <v-btn icon>
                                <v-icon @click="openrtEDialog(regtypes.id, regtypes.reg_type, regtypes.reg_type_date)">edit</v-icon>
                              </v-btn>

                              <v-layout row justify-center>
                                <v-dialog
                                        v-model="rtedialog == regtypes.id? true : false"
                                        persistent
                                        max-width="500"
                                >
                                  <v-card>

                                    <v-card-title>
                                      <span class="headline">Edit Registration Type</span>
                                    </v-card-title>

                                    <v-card-text>
                                      <v-container grid-list-md>
                                        <v-form :ref="`rteform${regtypes.id}`" v-model="valid" lazy-validation>
                                          <v-layout wrap>

                                            <v-flex xs6 sm7 md7>

                                              <v-text-field
                                                      v-model="rteform.regtype"
                                                      :rules="rteRules"
                                                      required>
                                              </v-text-field>

                                              <v-menu
                                                      :close-on-content-click="false"
                                                      v-model="regcatmenu"
                                                      lazy
                                              >
                                                <v-text-field
                                                        slot="activator"
                                                        v-model="rteform.regdate"
                                                        :rules="rteRules"
                                                        label="Date"
                                                        append-icon="event"
                                                        readonly
                                                ></v-text-field>
                                                <v-date-picker v-model="rteform.regdate" @input="regcatmenu = false"></v-date-picker>
                                              </v-menu>

                                            </v-flex>

                                            <v-flex xs6 sm5 md5>

                                            </v-flex>

                                          </v-layout>
                                        </v-form>
                                      </v-container>
                                    </v-card-text>


                                    <v-card-actions>
                                      <v-spacer></v-spacer>
                                      <v-btn color="blue darken-1" flat @click="rtedialog = false">Close</v-btn>
                                      <v-btn color="blue darken-1" flat @click="rtesubmit(`rteform${regtypes.id}`, regtypes.id)">Update</v-btn>
                                    </v-card-actions>

                                  </v-card>
                                </v-dialog>
                              </v-layout>

                            </td>
                          </tr>

                          <tr v-for="categories in regsmenus.categories">
                            <td>
                              <a @click="cdelete(categories.id)">Delete</a>
                              <a @click="openCEdialog(categories.id, categories.category)">Edit</a>

                              <v-layout row justify-center>
                                <v-dialog
                                        v-model="cedialog == categories.id? true : false"
                                        persistent
                                        max-width="500"
                                >
                                  <v-card>

                                    <v-card-title>
                                      <span class="headline">Edit Category</span>
                                    </v-card-title>

                                    <v-card-text>
                                      <v-container grid-list-md>
                                        <v-form :ref="`ceform${categories.id}`" v-model="valid" lazy-validation>
                                          <v-layout wrap>

                                            <v-flex xs6 sm7 md7>

                                              <v-text-field
                                                      v-model="ceform.category"
                                                      :rules="ceRules"
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
                                      <v-btn color="blue darken-1" flat @click="cedialog = false">Close</v-btn>
                                      <v-btn color="blue darken-1" flat @click="cesubmit(`ceform${categories.id}`, categories.id)">Update</v-btn>
                                    </v-card-actions>

                                  </v-card>
                                </v-dialog>
                              </v-layout>

                            </td>
                            <td class="font-weight-bold">{{categories.category}}</td>
                            <td v-for="registrations in categories.registrations">
                              {{registrations.amount}}
                              <a @click="openAdialog(registrations.id, registrations.amount)">Edit</a>

                              <v-layout row justify-center>
                                <v-dialog
                                        v-model="adialog == registrations.id? true : false"
                                        persistent
                                        max-width="500"
                                >
                                  <v-card>

                                    <v-card-title>
                                      <span class="headline">Edit Amount</span>
                                    </v-card-title>

                                    <v-card-text>
                                      <v-container grid-list-md>
                                        <v-form :ref="`aform${registrations.id}`" v-model="valid" lazy-validation>
                                          <v-layout wrap>

                                            <v-flex xs6 sm7 md7>

                                              <v-text-field
                                                      v-model="aform.amount"
                                                      :rules="aRules"
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
                                      <v-btn color="blue darken-1" flat @click="adialog = false">Close</v-btn>
                                      <v-btn color="blue darken-1" flat @click="asubmit(`aform${registrations.id}`, registrations.id)">Update</v-btn>
                                    </v-card-actions>

                                  </v-card>
                                </v-dialog>
                              </v-layout>

                            </td>
                          </tr>
                        </v-card-text>

                      </v-card>

                    </table>

                  </div>
                </v-card-text>

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
        name: "confreg",
        data:() =>{
            return{
                id: 0,
                cdialog: false,
                cedialog: false,
                curdialog: false,
                rtdialog: false,
                rtedialog: false,
                rsmdialog: false,
                smdialog: false,
                emdialog: false,
                mdialog: false,
                adialog: false,
                valid: false,
                regdmenu: false,
                regcatmenu: false,
                cform:{
                    category: '',
                },
                ceform:{
                    category: '',
                },
                curform:{
                    curtype : '',
                },
                rtform:{
                    regtype: '',
                    regdate: ''
                },
                rteform:{
                    regtype: '',
                    regdate: ''
                },
                rsmform:{
                    regsmenu: ''
                },
                smform:{
                    regsmenu: ''
                },
                emform:{
                    regmenu: ''
                },
                mform:{
                    regmenu: ''
                },
                aform:{
                  amount: ''
                },
                cRules:[
                    (v) => !!v || 'Category is Required'
                ],
                curRules:[
                    (v) => !!v || 'Currency type is Required'
                ],
                rtRules:[
                    (v) => !!v || 'Registration type is Required'
                ],
                rteRules:[
                    (v) => !!v || 'Registration type is Required'
                ],
                rsmRules:[
                    (v) => !!v || 'Registration submenu is Required'
                ],
                smRules:[
                    (v) => !!v || 'Registration submenu is Required'
                ],
                emRules:[
                    (v) => !!v || 'Registration menu is Required'
                ],
                mRules:[
                    (v) => !!v || 'Registration menu is Required'
                ],
                aRules:[
                    (v) => !!v || 'Amount is Required'
                ],
                ceRules:[
                    (v) => !!v || 'Category is Required'
                ]
            }
        },
        created(){
            this.id = this.$route.params.id;
        },
        mounted(){
            this.$store.dispatch('fetchRegdetails', this.id);
        },
        methods:{
            openCdialog(regsmenuid){
                this.cdialog = regsmenuid;
            },
            openCEdialog(categoryid, category){
                this.cedialog = categoryid;
                this.ceform.category = category;
            },
            openCurdialog(regmenuid){
                this.curdialog = regmenuid;
            },
            openRTdialog(regmenuid){
                this.rtdialog = regmenuid;
            },
            openrtEDialog(regtypeid, regtype, regdate){
                this.rtedialog = regtypeid;
                this.rteform.regtype = regtype;
                this.rteform.regdate = regdate;
            },
            openrsMDialog(regsmenuid, regsmenu){
                this.rsmdialog = regsmenuid;
                this.rsmform.regsmenu = regsmenu;
            },
            opensMDialog(regmenuid){
                this.smdialog = regmenuid;
            },
            openeMDialog(regmenuid, regmenu){
                this.emdialog = regmenuid;
                this.emform.regmenu = regmenu;
            },
            openMDialog(){
                this.mdialog = true;
            },
            openAdialog(regid, amount){
                this.adialog = regid;
                this.aform.amount = amount;
            },
            csubmit(form, regsmenuid, regmenuid){
                console.log(this.$refs[form][0]);
                //alert(regmenuid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('addRCategory', {id: this.id, regsmenuid, regmenuid, formData: this.$data.cform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            cdelete(catid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteRCategory', {catid, id: this.id});
            },
            cursubmit(form, regmenuid){
                console.log(this.$refs[form][0]);
                //alert(regmenuid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('addRCurtype', {id: this.id, regmenuid, formData: this.$data.curform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.curdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            rtsubmit(form, regmenuid){
                console.log(this.$refs[form][0]);
                //alert(regmenuid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('addRegtype', {id: this.id, regmenuid, formData: this.$data.rtform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.rtdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            rtesubmit(form, regtypeid){
                console.log(this.$refs[form][0]);
                //alert(regtypeid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('UpdateRegtype', {id: this.id, regtypeid, formData: this.$data.rteform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.rtedialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            rsmsubmit(form, regsmenuid){
                console.log(this.$refs[form][0]);
                //alert(regsmenuid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('UpdateRegsubmenu', {id: this.id, regsmenuid, formData: this.$data.rsmform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.rsmdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            smsubmit(form, regmenuid){
                console.log(this.$refs[form][0]);
                //alert(regmenuid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('addRSubmenu', {id: this.id, regmenuid, formData: this.$data.smform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.smdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            emsubmit(form, regmenuid){
                console.log(this.$refs[form][0]);
                //alert(regmenuid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('UpdateRMenu', {id: this.id, regmenuid, formData: this.$data.emform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.emdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            msubmit(form){
                console.log(this.$refs[form][0]);
                //alert('hi');
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('addRMenu', {id: this.id, formData: this.$data.mform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.mdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            asubmit(form, regid){
                console.log(this.$refs[form][0]);
                //alert(regid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('updateRAmount', {id: this.id, regid, formData: this.$data.aform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.adialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            cesubmit(form, catid){
                console.log(this.$refs[form][0]);
                //alert(catid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('updateRCategory', {id: this.id, catid, formData: this.$data.ceform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cedialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            rtCDelete(regtypeid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteCRtype', {regtypeid, id: this.id});
            },
            rsmDelete(regsmenuid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteRsmenu', {regsmenuid, id: this.id});
            },
            rmDelete(regmenuid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteRmenu', {regmenuid, id: this.id});
            }
        },
        computed:{
            ...mapState(['regDetails'])
        }
    }
</script>

<style scoped>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }
</style>