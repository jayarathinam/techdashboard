<template>
    <v-card flat color="background" class="ma-4">

        <v-layout row wrap>

            <v-flex class="pa-2 xs6">
                <h1>Ocm details</h1>
            </v-flex>

            <v-flex class="pa-2 xs6">
                <v-btn color="dbluebutton" class="white--text" @click="tdialog = !tdialog">Add OCM Title</v-btn>
            </v-flex>

            <v-layout row justify-center>
                <v-dialog
                        v-model="tdialog"
                        persistent
                        max-width="500"
                >
                    <v-card>

                        <v-card-title>
                            <span class="headline">Add New Title</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container grid-list-md>
                                <v-form :ref="tform" v-model="valid" lazy-validation>
                                    <v-layout wrap>

                                        <v-flex xs12 sm6 md6>
                                            <v-text-field
                                                    v-model="tform.title"
                                                    :rules="tRules"
                                                    required>
                                            </v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </v-form>
                            </v-container>
                        </v-card-text>


                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click="tdialog = false">Close</v-btn>
                            <v-btn color="blue darken-1" flat @click="tsubmit()">Add</v-btn>
                        </v-card-actions>

                    </v-card>
                </v-dialog>
            </v-layout>

        </v-layout>

        <v-layout row wrap v-for="ocms in ocm[0].ocmtitles" :key="ocms.id" class="pa-2 mt-4">
            <v-flex class="xs12">
               <!-- <h4>{{ocms}}</h4>-->
                <v-layout row wrap>
                    <v-flex class="xs12">

                        <v-card flat>
                            <v-toolbar color="pink" dark flat>
                                <v-toolbar-title>{{ocms.priority}}.{{ocms.ocmtitle}}</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-btn icon>
                                    <v-icon @click="openeTdialog(ocms.id, ocms.ocmtitle)">create</v-icon>
                                </v-btn>
                                <v-btn icon>
                                    <v-icon @click="openSdialog(ocms.id)">library_add</v-icon>
                                </v-btn>
                                <v-btn icon>
                                    <v-icon @click="openPtdialog(ocms.priority, ocms.id)">loop</v-icon>
                                </v-btn>
                                <v-btn icon>
                                    <v-icon @click="deleteOcmtitle(ocms.id)">delete</v-icon>
                                </v-btn>
                            </v-toolbar>
                        </v-card>

                       <!-- <v-layout row wrap>
                            <v-flex class="xs3">
                                <h2>{{ocms.priority}}.{{ocms.ocmtitle}}</h2>
                            </v-flex>

                            <v-flex class="xs6">
                                <v-btn flat>
                                    <v-icon @click="openSdialog(ocms.id)">library_add</v-icon>
                                </v-btn>
                                <v-btn flat>
                                    <v-icon @click="openPtdialog(ocms.priority, ocms.id)">loop</v-icon>
                                </v-btn>
                                <v-btn flat>
                                    <v-icon @click="deleteOcmtitle(ocms.id)">delete</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>-->

                        <v-layout row justify-center>
                            <v-dialog
                                    v-model="sdialog == ocms.id? true : false"
                                    persistent
                                    max-width="500"
                            >
                                <v-card>

                                    <v-card-title>
                                        <span class="headline">Add New Subtitle of {{ocms.ocmtitle}}</span>
                                    </v-card-title>

                                    <v-card-text>
                                        <v-container grid-list-md>
                                            <v-form :ref="`sform${ocms.id}`" v-model="valid" lazy-validation>
                                                <v-layout wrap>

                                                    <v-flex xs12 sm6 md6>
                                                        <v-text-field
                                                                v-model="sform.stitle"
                                                                :rules="sRules"
                                                                required>
                                                        </v-text-field>
                                                    </v-flex>
                                                </v-layout>
                                            </v-form>
                                        </v-container>
                                    </v-card-text>


                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" flat @click="sdialog = false">Close</v-btn>
                                        <v-btn color="blue darken-1" flat @click="ssubmit(`sform${ocms.id}`, ocms.id)">Add</v-btn>
                                    </v-card-actions>

                                </v-card>
                            </v-dialog>
                        </v-layout>

                    </v-flex>

                            <v-layout row justify-center>
                                <v-dialog
                                        v-model="ptdialog == ocms.id? true : false"
                                        persistent
                                        max-width="500"
                                >
                                    <v-card>

                                        <v-card-title>
                                            <span class="headline">Change Title Order</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container grid-list-md>
                                                <v-form :ref="`ptform${ocms.id}`" v-model="valid" lazy-validation>
                                                    <v-layout wrap>

                                                        <v-flex xs12 sm6 md6>
                                                            <v-text-field
                                                                    v-model="ptform.priority"
                                                                    :rules="pRules"
                                                                    required>
                                                            </v-text-field>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-form>
                                            </v-container>
                                        </v-card-text>


                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" flat @click="ptdialog = false">Close</v-btn>
                                            <v-btn color="blue darken-1" flat @click="ptsubmit(`ptform${ocms.id}`, ocms.id)">Change</v-btn>
                                        </v-card-actions>

                                    </v-card>
                                </v-dialog>
                            </v-layout>

                    <v-layout row justify-center>
                        <v-dialog
                                v-model="etdialog == ocms.id? true : false"
                                persistent
                                max-width="500"
                        >
                            <v-card>

                                <v-card-title>
                                    <span class="headline">Change Title</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-form :ref="`etform${ocms.id}`" v-model="valid" lazy-validation>
                                            <v-layout wrap>

                                                <v-flex xs12 sm6 md6>
                                                    <v-text-field
                                                            v-model="etform.title"
                                                            :rules="tRules"
                                                            required>
                                                    </v-text-field>
                                                </v-flex>
                                            </v-layout>
                                        </v-form>
                                    </v-container>
                                </v-card-text>


                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" flat @click="etdialog = false">Close</v-btn>
                                    <v-btn color="blue darken-1" flat @click="etsubmit(`etform${ocms.id}`, ocms.id)">Update</v-btn>
                                </v-card-actions>

                            </v-card>
                        </v-dialog>
                    </v-layout>

                        </v-layout>
                    </v-flex>

                    <v-flex v-for="ocmsub in ocms.ocmsubtitles" :key="ocmsub.id" class="xs6">
                      <!--  <h4>{{ocmsub}}</h4>-->
                        <v-layout row wrap class="mt-2">

                            <v-flex class="xs12 ma-2">

                                <v-card flat>
                                    <v-toolbar color="cyan" dark flat>
                                        <v-toolbar-title>{{ocmsub.priority}}.{{ocmsub.ocmsubtitle}}</v-toolbar-title>
                                        <v-spacer></v-spacer>
                                        <v-btn icon>
                                            <v-icon @click="openeSdialog(ocmsub.id, ocmsub.ocmsubtitle)">create</v-icon>
                                        </v-btn>
                                        <v-btn icon>
                                            <v-icon @click="openDialog(ocmsub.id)">library_add</v-icon>
                                        </v-btn>
                                        <v-btn icon>
                                            <v-icon @click="openPsdialog(ocmsub.priority, ocmsub.id)">loop</v-icon>
                                        </v-btn>
                                        <v-btn icon>
                                            <v-icon @click="deleteOcmsubtitle(ocmsub.id)">delete</v-icon>
                                        </v-btn>
                                    </v-toolbar>
                                </v-card>


                                  <!--  <v-flex class="xs3">
                                        <h3>{{ocmsub.priority}}.{{ocmsub.ocmsubtitle}}</h3>
                                    </v-flex>

                                    <v-flex class="xs6">
                                        <v-btn icon>
                                            <v-icon @click="openeSdialog(ocmsub.id, ocmsub.ocmsubtitle)">create</v-icon>
                                        </v-btn>
                                        <v-btn flat>
                                            <v-icon @click="openDialog(ocmsub.id)">library_add</v-icon>
                                        </v-btn>
                                        <v-btn flat>
                                            <v-icon @click="openPsdialog(ocmsub.priority, ocmsub.id)" >loop</v-icon>
                                        </v-btn>
                                        <v-btn flat>
                                            <v-icon @click="deleteOcmsubtitle(ocmsub.id)" >delete</v-icon>
                                        </v-btn>
                                    </v-flex>-->

                                    <v-layout row justify-center>
                                        <v-dialog
                                                v-model="esdialog == ocmsub.id? true : false"
                                                persistent
                                                max-width="500"
                                        >
                                            <v-card>

                                                <v-card-title>
                                                    <span class="headline">Change Subtitle</span>
                                                </v-card-title>

                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-form :ref="`esform${ocmsub.id}`" v-model="valid" lazy-validation>
                                                            <v-layout wrap>

                                                                <v-flex xs12 sm6 md6>
                                                                    <v-text-field
                                                                            v-model="esform.stitle"
                                                                            :rules="sRules"
                                                                            required>
                                                                    </v-text-field>
                                                                </v-flex>
                                                            </v-layout>
                                                        </v-form>
                                                    </v-container>
                                                </v-card-text>


                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="blue darken-1" flat @click="esdialog = false">Close</v-btn>
                                                    <v-btn color="blue darken-1" flat @click="essubmit(`esform${ocmsub.id}`, ocmsub.id)">Update</v-btn>
                                                </v-card-actions>

                                            </v-card>
                                        </v-dialog>
                                    </v-layout>

                                    <v-layout row justify-center>
                                        <v-dialog
                                                v-model="psdialog == ocmsub.id? true : false"
                                                persistent
                                                max-width="500"
                                        >
                                            <v-card>

                                                <v-card-title>
                                                    <span class="headline">Change Subtitle Order</span>
                                                </v-card-title>

                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-form :ref="`psform${ocmsub.id}`" v-model="valid" lazy-validation>
                                                            <v-layout wrap>

                                                                <v-flex xs12 sm6 md6>
                                                                    <v-text-field
                                                                            v-model="psform.priority"
                                                                            :rules="pRules"
                                                                            required>
                                                                    </v-text-field>
                                                                </v-flex>
                                                            </v-layout>
                                                        </v-form>
                                                    </v-container>
                                                </v-card-text>


                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="blue darken-1" flat @click="psdialog = false">Close</v-btn>
                                                    <v-btn color="blue darken-1" flat @click="pssubmit(`psform${ocmsub.id}`, ocmsub.id)">Change</v-btn>
                                                </v-card-actions>

                                            </v-card>
                                        </v-dialog>
                                    </v-layout>

                                    <v-layout row justify-center>

                                        <v-dialog
                                                v-model="dialog == ocmsub.id? true : false"
                                                persistent
                                                max-width="500"
                                        >
                                            <v-card>

                                                <v-card-title>
                                                    <span class="headline">Add {{ocmsub.ocmsubtitle}}</span>
                                                </v-card-title>

                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-form :ref="`form${ocmsub.id}`" v-model="valid" lazy-validation>
                                                        <v-layout wrap>

                                                            <v-flex xs12 sm6 md6>
                                                                <v-text-field
                                                                        label="Name*"
                                                                        v-model="form.name"
                                                                        :rules="nameRules"
                                                                        required>
                                                                </v-text-field>
                                                            </v-flex>

                                                            <v-flex xs12 sm6 md6>
                                                                <v-text-field
                                                                        label="Designation*"
                                                                        v-model="form.dnation"
                                                                        :rules="desRules"
                                                                        required>
                                                                </v-text-field>
                                                            </v-flex>

                                                            <v-flex xs12 sm6 md6>
                                                                <v-text-field
                                                                        label="College*"
                                                                        v-model="form.college"
                                                                        :rules="colRules"
                                                                        required>
                                                                </v-text-field>
                                                            </v-flex>

                                                            <v-flex xs12 sm6 md6>
                                                                <v-text-field
                                                                        label="Departmant*"
                                                                        v-model="form.dept"
                                                                        :rules="deptRules"
                                                                        required>
                                                                </v-text-field>
                                                            </v-flex>

                                                            <v-flex xs12 sm6 md6>
                                                                <v-text-field
                                                                        label="Place*"
                                                                        v-model="form.place"
                                                                        :rules="placeRules"
                                                                        required>
                                                                </v-text-field>
                                                            </v-flex>

                                                            <v-flex xs12 sm6 md6>
                                                                <v-text-field
                                                                        label="country*"
                                                                        v-model="form.country"
                                                                        :rules="countryRules"
                                                                        required>
                                                                </v-text-field>
                                                            </v-flex>

                                                            <v-flex xs6 sm7 md7>
                                                                <v-text-field
                                                                        label="Upload Image"
                                                                        @click="pickFile(`image${ocmsub.id}`)"
                                                                        v-model="imageName"
                                                                        hint="This is not required"
                                                                        prepend-icon="camera"
                                                                >
                                                                </v-text-field>
                                                                <input
                                                                        type="file"
                                                                        style="display:none"
                                                                        :ref="`image${ocmsub.id}`"
                                                                        accept="image/*"
                                                                        @change="onFilePicked"
                                                                >
                                                            </v-flex>

                                                            <v-flex xs6 sm5 md5>
                                                                <v-avatar size="100px">
                                                                    <img :src="form.imageFile? form.imageFile : '/images/admin.png'" height="100">
                                                                </v-avatar>
                                                            </v-flex>
                                                        </v-layout>

                                                        </v-form>
                                                    </v-container>
                                                    <small>*indicates required field</small>
                                                </v-card-text>

                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="blue darken-1" flat @click="closeDialog()">Close</v-btn>
                                                    <v-btn color="blue darken-1" flat @click="submit(`form${ocmsub.id}`, ocmsub.id)">Save</v-btn>
                                                </v-card-actions>

                                            </v-card>
                                        </v-dialog>
                                    </v-layout>

                                <v-layout row wrap>

                                    <v-flex v-for="ocmdet in ocmsub.ocms" :key="ocmdet.id" class="xs6">

                                        <v-card class="ma-2" color="blue lighten-2">
                                            <v-chip label color="pink" text-color="white">
                                                {{ocmdet.priority}}
                                            </v-chip>
                                            <v-btn icon>
                                                <v-icon @click="openEdialog(ocmdet.id, ocmdet.name, ocmdet.designation, ocmdet.college, ocmdet.department, ocmdet.place, ocmdet.country)"
                                                >
                                                    create
                                                </v-icon>
                                            </v-btn>
                                            <v-btn icon>
                                                <v-icon @click="openPdialog(ocmdet.priority,ocmdet.id)">loop</v-icon>
                                            </v-btn>
                                            <v-btn icon>
                                                <v-icon @click="deleteOcm(ocmdet.id)">delete</v-icon>
                                            </v-btn>

                                            <div class="text-xs-center" color="white">
                                                <v-btn fab icon @click="openIdialog(ocmdet.id)">
                                                    <v-avatar size="80px">
                                                        <v-img
                                                                :src="ocmdet.profile_image_path"
                                                                height="80"
                                                                contain
                                                        ></v-img>
                                                    </v-avatar>
                                                </v-btn>
                                            </div>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="idialog == ocmdet.id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Change Image</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`iform${ocmdet.id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>
                                                                            <v-text-field
                                                                                    label="Upload Image"
                                                                                    @click="pickFile(`iimage${ocmdet.id}`)"
                                                                                    v-model="uimageName"
                                                                                    hint="This is not required"
                                                                                    prepend-icon="camera"
                                                                            >
                                                                            </v-text-field>
                                                                            <input
                                                                                    type="file"
                                                                                    style="display:none"
                                                                                    :ref="`iimage${ocmdet.id}`"
                                                                                    accept="image/*"
                                                                                    @change="oniFilePicked"
                                                                            >
                                                                        </v-flex>

                                                                        <v-flex xs6 sm5 md5>
                                                                            <v-avatar size="100px">
                                                                                <img :src="iform.imageFile? iform.imageFile : '/images/admin.png'" height="100">
                                                                            </v-avatar>
                                                                        </v-flex>

                                                                    </v-layout>
                                                                </v-form>
                                                            </v-container>
                                                        </v-card-text>


                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn color="blue darken-1" flat @click="idialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="isubmit(`iform${ocmdet.id}`, ocmdet.id)">Change</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="pdialog == ocmdet.id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Change Order</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`pform${ocmdet.id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs12 sm6 md6>
                                                                            <v-text-field
                                                                                    v-model="pform.priority"
                                                                                    :rules="pRules"
                                                                                    required>
                                                                            </v-text-field>
                                                                        </v-flex>
                                                                    </v-layout>
                                                                </v-form>
                                                            </v-container>
                                                        </v-card-text>


                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn color="blue darken-1" flat @click="pdialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="psubmit(`pform${ocmdet.id}`, ocmdet.id)">Change</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="edialog == ocmdet.id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Update OCM Details</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`eform${ocmdet.id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs12 sm6 md6>
                                                                            <v-text-field
                                                                                    label="Name"
                                                                                    v-model="eform.name"
                                                                                    :rules="nameRules"
                                                                                    required>
                                                                            </v-text-field>
                                                                        </v-flex>

                                                                        <v-flex xs12 sm6 md6>
                                                                            <v-text-field
                                                                                    label="Designation"
                                                                                    v-model="eform.dnation"
                                                                                    :rules="desRules"
                                                                                    required>
                                                                            </v-text-field>
                                                                        </v-flex>

                                                                        <v-flex xs12 sm6 md6>
                                                                            <v-text-field
                                                                                    label="College"
                                                                                    v-model="eform.college"
                                                                                    :rules="colRules"
                                                                                    required>
                                                                            </v-text-field>
                                                                        </v-flex>

                                                                        <v-flex xs12 sm6 md6>
                                                                            <v-text-field
                                                                                    label="Department"
                                                                                    v-model="eform.dept"
                                                                                    :rules="deptRules"
                                                                                    required>
                                                                            </v-text-field>
                                                                        </v-flex>

                                                                        <v-flex xs12 sm6 md6>
                                                                            <v-text-field
                                                                                    label="Place"
                                                                                    v-model="eform.place"
                                                                                    :rules="placeRules"
                                                                                    required>
                                                                            </v-text-field>
                                                                        </v-flex>

                                                                        <v-flex xs12 sm6 md6>
                                                                            <v-text-field
                                                                                    label="Country"
                                                                                    v-model="eform.country"
                                                                                    :rules="countryRules"
                                                                                    required>
                                                                            </v-text-field>
                                                                        </v-flex>

                                                                    </v-layout>
                                                                </v-form>
                                                            </v-container>
                                                        </v-card-text>


                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn color="blue darken-1" flat @click="edialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="esubmit(`eform${ocmdet.id}`, ocmdet.id)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                            <v-card-title primary-title>
                                                <div>
                                                    <h2 class="headline mb-0 white--text">{{ocmdet.name}}</h2>
                                                    <div> {{ ocmdet.designation }} </div>
                                                    <div> {{ ocmdet.college }} </div>
                                                </div>
                                            </v-card-title>

                                            <v-card-actions>

                                            </v-card-actions>
                                        </v-card>

                                    </v-flex>

                                </v-layout>

                            </v-flex>

                        </v-layout>
                    </v-flex>
                </v-layout>

    </v-card>

</template>

<script>
    import { mapState } from 'vuex';
    import { Validator } from 'vee-validate';

    export default {
        name: "cms",
        data:() => ({
                id: 0,
                dialog: false,
                sdialog: false,
                pdialog: false,
                psdialog: false,
                ptdialog: false,
                etdialog: false,
                esdialog: false,
                idialog: false,
                edialog: false,
                tdialog: false,
                valid: true,
                imageName : '',
                imageUrl: '',
                imageFile: '',
                uimageName : '',
                uimageUrl: '',
                uimageFile: '',
                form :{
                    name: '',
                    dnation: '',
                    college: '',
                    dept: '',
                    place: '',
                    country: '',
                    imageFile: '',
                },
                eform :{
                    name: '',
                    dnation: '',
                    college: '',
                    dept: '',
                    place: '',
                    country: '',
                },
                iform :{
                    imageFile: '',
                },
                sform :{
                    stitle: '',
                },
                pform : {
                    priority : '',
                },
                psform : {
                    priority: '',
                },
                ptform: {
                    priority: '',
                },
                tform: {
                  title: '',
                },
                etform: {
                title: '',
                },
                esform: {
                    stitle: '',
                },
                nameRules:[
                    (v) => !!v || 'Name is Required'
                ],
                desRules:[
                    (v) => !!v || 'Designation is Required'
                ],
                colRules:[
                    (v) => !!v || 'College is Required'
                ],
                deptRules:[
                    (v) => !!v || 'Department is required'
                ],
                placeRules:[
                    (v) => !!v || 'Place is Required'
                ],
                countryRules:[
                    (v) => !!v || 'Country is Required'
                ],
                pRules:[
                    (v) => !!v || 'Priority is Required'
                ],
                sRules:[
                (v) => !!v || 'Subtitle is Required'
                ],
                tRules:[
                    (v) => !!v || 'Title is Required'
                ]

        }),
        watch:{
            dialog(val){
                val = false;
            }
        },
        created(){
            this.id = this.$route.params.id;
        },
        mounted(){
            this.$store.dispatch('fetchProjdetails', this.id);
            this.$store.dispatch('fetchOcmdetails', this.id);
            console.log(this.$refs);
        },
        methods: {
            submit(form, ocmsubid){
                console.log(this.$refs[form][0]);
                if(this.$refs[form][0].validate()){
                    //alert(this.$data.form.imageFile);
                    this.$store.dispatch('insertOcm', {id: this.id, ocmsubid, formData: this.$data.form}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            tsubmit(){
                //alert(this.tform.title);
                this.$store.dispatch('insertOcmtitle', {id: this.id, formData: this.$data.tform}, );
            },
            etsubmit(form, ocmtid){
                console.log(this.$refs[form][0]);
                if(this.$refs[form][0].validate()){
                    //alert(this.$data.form.imageFile);
                    this.$store.dispatch('updateOcmtitle', {id: this.id, ocmtid, formData: this.$data.etform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            essubmit(form, ocmsid){
                console.log(this.$refs[form][0]);
                if(this.$refs[form][0].validate()){
                    //alert(this.$data.form.imageFile);
                    this.$store.dispatch('updateOcmsub', {id: this.id, ocmsid, formData: this.$data.esform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            esubmit(form, ocmid){
                console.log(this.$refs[form][0]);
                if(this.$refs[form][0].validate()){
                    //alert(this.$data.form.imageFile);
                    this.$store.dispatch('updateOcm', {id: this.id, ocmid, formData: this.$data.eform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            ssubmit(form, ocmtid){
                console.log(this.$refs[form][0]);
                if(this.$refs[form][0].validate()){
                    //alert(this.$data.form.imageFile);
                    this.$store.dispatch('insertOcmsub', {id: this.id, ocmtid, formData: this.$data.sform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            psubmit(form, ocmid){
                console.log(this.$refs[form][0]);
                //alert(ocmid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('updateOcmPriority', {id: this.id, ocmid, formData: this.$data.pform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            isubmit(form, ocmid){
                console.log(this.$refs[form][0]);
                //alert(ocmid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('updateOcmImage', {id: this.id, ocmid, formData: this.$data.iform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            pssubmit(form, ocmsubid){
                //alert(ocmsubid);
                console.log(this.$refs[form][0]);
                //alert(ocmid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('updateOcmsubPriority', {id: this.id, ocmsubid, formData: this.$data.psform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            ptsubmit(form, ocmtid){
                //alert(ocmsubid);
                console.log(this.$refs[form][0]);
                //alert(ocmid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('updateOcmtitlePriority', {id: this.id, ocmtid, formData: this.$data.ptform}, );
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            openDialog(ocmid){
                //alert(ocmid);
                this.dialog = ocmid;
                //alert(this.dialog);
            },
            openEdialog(ocmid, name, designation, college, dept, place, country){
                this.edialog = ocmid;
                this.eform.name = name;
                this.eform.dnation = designation;
                this.eform.college = college;
                this.eform.dept = dept;
                this.eform.place = place;
                this.eform.country = country;
            },
            openeTdialog(ocmtid, ocmtitle){
                this.etdialog = ocmtid;
                this.etform.title = ocmtitle;
            },
            openeSdialog(ocmsubid, ocmstitle){
                this.esdialog = ocmsubid;
                this.esform.stitle = ocmstitle;
            },
            openSdialog(ocmtid){
                this.sdialog = ocmtid;
            },
            openIdialog(ocmid){
                this.idialog = ocmid;
            },
            openPdialog(priority, ocmid){
                this.pform.priority = priority;
                this.pdialog = ocmid;
            },
            openPsdialog(priority, ocmsubid){
                //alert(priority);
                this.psform.priority = priority;
                this.psdialog = ocmsubid;
            },
            openPtdialog(priority, ocmtid){
                //alert(priority+''+ocmtid);
                this.ptform.priority = priority;
                this.ptdialog = ocmtid;
            },
            closeDialog(){
                this.imageName = '';
                this.imageUrl = '';
                this.imageFile = '';
                this.form.imageFile = '';
                this.dialog = false;
            },
            pickFile(image){
                this.$refs[image][0].click();
            },
            onFilePicked(e){
                const  files = e.target.files;
                if(files[0] !== undefined){
                    //this.form.imageFile = files[0];
                    this.imageName = files[0].name;
                    const fr = new FileReader()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.form.imageFile = fr.result
                        this.imageFile = files[0]
                    })

                    //alert(this.imageUrl);
                }
                else{
                    this.imageName = ''
                    this.imageUrl = ''
                    this.imageFile = ''
                }
            },
            oniFilePicked(e){
                const  files = e.target.files;
                if(files[0] !== undefined){
                    //this.form.imageFile = files[0];
                    this.uimageName = files[0].name;
                    const fr = new FileReader()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.iform.imageFile = fr.result
                        this.uimageFile = files[0]
                    })

                    //alert(this.imageUrl);
                }
                else{
                    this.uimageName = ''
                    this.uimageUrl = ''
                    this.uimageFile = ''
                }
            },
            deleteOcm(ocmId){
                //alert(id);
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteOcm', {ocmId, id: this.id})
            },
            deleteOcmtitle(ocmtitleId){
                //alert(ocmtitleId);
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteOcmtitle', {ocmtitleId, id: this.id})
            },
            deleteOcmsubtitle(ocmsubId){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteOcmsubtitle', {ocmsubId, id: this.id})
            }
        },
        computed:{
            ...mapState(['ocm'])
        }
    }
</script>

<style scoped>

</style>