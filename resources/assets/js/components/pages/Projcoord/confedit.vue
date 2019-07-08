<template>
    <v-card color="mback" flat>
        <v-layout row wrap>
            <v-flex xs12>
                <v-progress-linear v-if="loading" :indeterminate="loading" class="ma-0" style="height: 4px;"></v-progress-linear>

                <v-card class="ma-4 pa-2" flat v-for="(item, index) in projectDetails" :key="item.id">
                    <v-layout row wrap>
                        <v-flex xs6>
                            <v-card flat class="border-success ml-2 mr-2">
                                <v-toolbar color="cyan" dark flat>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>

                                    <v-toolbar-title>Basic Details</v-toolbar-title>

                                    <v-spacer></v-spacer>

                                    <v-btn icon>
                                        <v-icon @click="openeBDdialog(item.id, item.fullname, item.name, item.type, item.city, item.country, item.venue)">edit</v-icon>
                                    </v-btn>

                                    <v-layout row justify-center>
                                        <v-dialog
                                                v-model="ebddialog"
                                                persistent
                                                max-width="500"
                                        >
                                            <v-card>

                                                <v-card-title>
                                                    <span class="headline">Edit Basic Details</span>
                                                </v-card-title>

                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-form :ref="ebdform" v-model="valid" lazy-validation>
                                                            <v-layout wrap>

                                                                <v-flex xs6 sm7 md10>

                                                                    <v-text-field
                                                                            v-model="ebdform.fullname"
                                                                            :rules="ebdRules"
                                                                            required>
                                                                    </v-text-field>

                                                                    <v-text-field
                                                                            v-model="ebdform.title"
                                                                            :rules="ebdRules"
                                                                            required>
                                                                    </v-text-field>

                                                                    <v-text-field
                                                                            v-model="ebdform.conftype"
                                                                            :rules="ebdRules"
                                                                            required>
                                                                    </v-text-field>

                                                                    <v-text-field
                                                                            v-model="ebdform.city"
                                                                            :rules="ebdRules"
                                                                            required>
                                                                    </v-text-field>

                                                                    <v-text-field
                                                                            v-model="ebdform.country"
                                                                            :rules="ebdRules"
                                                                            required>
                                                                    </v-text-field>

                                                                    <v-text-field
                                                                            v-model="ebdform.venue"
                                                                            :rules="ebdRules"
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
                                                    <v-btn color="blue darken-1" flat @click="ebddialog = false">Close</v-btn>
                                                    <v-btn color="blue darken-1" flat @click="ebdsubmit(ebdform)">Update</v-btn>
                                                </v-card-actions>

                                            </v-card>
                                        </v-dialog>
                                    </v-layout>

                                </v-toolbar>


                                <v-card-text>
                                    <div class="title">
                                        <div class="mb-4">{{item.fullname}} ({{item.name}})</div>
                                        <div class="subheading mb-3">{{item.type}} Conference</div>
                                        <div class="subheading mb-3">{{item.city}}, {{item.country}}</div>
                                        <div class="subheading mb-3">{{item.venue}}</div>
                                    </div>
                                </v-card-text>

                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card flat class="border-success ml-2 mr-2">
                                <v-toolbar color="cyan" dark flat>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>

                                    <v-toolbar-title>Important Dates</v-toolbar-title>

                                    <v-spacer></v-spacer>

                                    <v-btn icon @click="openACDdialog()">
                                        <v-icon>library_add</v-icon>
                                    </v-btn>

                                    <v-btn icon>
                                        <v-icon>edit</v-icon>
                                    </v-btn>

                                </v-toolbar>

                                <v-layout row justify-center>
                                    <v-dialog
                                            v-model="acddialog"
                                            persistent
                                            max-width="500"
                                    >
                                        <v-card>

                                            <v-card-title>
                                                <span class="headline">Add Important Date</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container grid-list-md>
                                                    <v-form :ref="`acdform${item.id}`" v-model="valid" lazy-validation @submit.prevent>
                                                        <v-layout wrap>

                                                            <v-flex xs6 sm7 md7>

                                                                <v-text-field
                                                                        v-model="acdform.idatemenu"
                                                                        :rules="acdRules"
                                                                        required>
                                                                </v-text-field>

                                                                <v-menu
                                                                        :close-on-content-click="false"
                                                                        v-model="acdmenu"
                                                                        lazy
                                                                >
                                                                    <v-text-field
                                                                            slot="activator"
                                                                            v-model="acdform.idate"
                                                                            :rules="acdRules"
                                                                            label="Date"
                                                                            append-icon="event"
                                                                            readonly
                                                                    ></v-text-field>
                                                                    <v-date-picker v-model="acdform.idate" @input="acdmenu = false"></v-date-picker>
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
                                                <v-btn color="blue darken-1" flat @click="acddialog = false">Close</v-btn>
                                                <v-btn color="blue darken-1" flat @click="acdsubmit(`acdform${item.id}`, loading)">Add</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-dialog>
                                </v-layout>


                                <v-card-text>

                                    <div class="title">
                                        <div class="mb-4">
                                            Conference Dates: <p>{{item.sdate}} to {{item.edate}}
                                            <v-btn icon @click="openCIDdialog(item.sdate, item.edate)">
                                            <v-icon>edit</v-icon>
                                            </v-btn>
                                        </p>
                                        </div>

                                        <v-layout row justify-center>
                                            <v-dialog
                                                    v-model="ciddialog"
                                                    persistent
                                                    max-width="500"
                                            >
                                                <v-card>

                                                    <v-card-title>
                                                        <span class="headline">Edit Conference Dates</span>
                                                    </v-card-title>

                                                    <v-card-text>
                                                        <v-container grid-list-md>
                                                            <v-form :ref="`cidform${item.id}`" v-model="valid" lazy-validation @submit.prevent>
                                                                <v-layout wrap>

                                                                    <v-flex xs6 sm7 md7>

                                                                        <v-menu
                                                                                :close-on-content-click="false"
                                                                                v-model="cidmenu"
                                                                                lazy
                                                                        >
                                                                            <v-text-field
                                                                                    slot="activator"
                                                                                    v-model="cidform.sdate"
                                                                                    :rules="cidRules"
                                                                                    label="Start Date"
                                                                                    append-icon="event"
                                                                                    readonly
                                                                            ></v-text-field>
                                                                            <v-date-picker v-model="cidform.sdate" @input="cidmenu = false"></v-date-picker>
                                                                        </v-menu>

                                                                        <v-menu
                                                                                :close-on-content-click="false"
                                                                                v-model="cidmenu2"
                                                                                lazy
                                                                        >
                                                                            <v-text-field
                                                                                    slot="activator"
                                                                                    v-model="cidform.edate"
                                                                                    :rules="cidRules"
                                                                                    label="End Date"
                                                                                    append-icon="event"
                                                                                    readonly
                                                                            ></v-text-field>
                                                                            <v-date-picker v-model="cidform.edate" @input="cidmenu = false"></v-date-picker>
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
                                                        <v-btn color="blue darken-1" flat @click="ciddialog = false">Close</v-btn>
                                                        <v-btn color="blue darken-1" flat @click="cidsubmit(`cidform${item.id}`)">Update</v-btn>
                                                    </v-card-actions>

                                                </v-card>
                                            </v-dialog>
                                        </v-layout>

                                        <div v-for="(itemd, index) in item.impdates">

                                            <div class="">

                                            </div>

                                                <div class="subheading mb-2">
                                                    {{itemd.priority}}.{{itemd['idatemenu'].idatemenu}}:
                                                    <a @click="openCDNdialog(itemd['idatemenu'].id, itemd['idatemenu'].idatemenu)">Edit</a>
                                                    <a @click="cdDelete(itemd['idatemenu'].id)">Delete</a>
                                                </div>
                                            <div class="subheading mb-3 font-weight-bold">
                                                {{itemd.impdate}}
                                                <a @click="openCDdialog(itemd.id, itemd.impdate)" class="font-weight-regular ml-2">Edit</a>
                                                <a @click="openCDOdialog(itemd.id, itemd.priority)" class="font-weight-regular ml-3">loop</a>
                                            </div>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="cdndialog == itemd['idatemenu'].id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Edit Important Date Menu</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`cdnform${itemd['idatemenu'].id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>

                                                                            <v-text-field
                                                                                    v-model="cdnform.idatemenu"
                                                                                    :rules="cdnRules"
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
                                                            <v-btn color="blue darken-1" flat @click="cdndialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="cdnsubmit(`cdnform${itemd['idatemenu'].id}`, itemd['idatemenu'].id)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="cddialog == itemd.id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Edit {{itemd['idatemenu'].idatemenu}}</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`cdform${itemd.id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>

                                                                            <v-menu
                                                                                    :close-on-content-click="false"
                                                                                    v-model="cdmenu"
                                                                                    lazy
                                                                            >
                                                                                <v-text-field
                                                                                        slot="activator"
                                                                                        v-model="cdform.idate"
                                                                                        :rules="cdRules"
                                                                                        label="Date"
                                                                                        append-icon="event"
                                                                                        readonly
                                                                                ></v-text-field>
                                                                                <v-date-picker v-model="cdform.idate" @input="cdmenu = false"></v-date-picker>
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
                                                            <v-btn color="blue darken-1" flat @click="cddialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="cdsubmit(`cdform${itemd.id}`, itemd.id)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="cdodialog == itemd.id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Change the Order</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`cdoform${itemd.id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>

                                                                            <v-text-field
                                                                                    v-model="cdoform.priority"
                                                                                    :rules="cdoRules"
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
                                                            <v-btn color="blue darken-1" flat @click="cdodialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="cdosubmit(`cdoform${itemd.id}`, itemd.priority)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                        </div>
                                    </div>
                                </v-card-text>

                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card flat class="border-success ml-2 mr-2">
                                <v-toolbar color="cyan" dark flat>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>

                                    <v-toolbar-title>Downloads</v-toolbar-title>

                                    <v-spacer></v-spacer>

                                    <v-btn icon @click="openADdialog()">
                                        <v-icon>library_add</v-icon>
                                    </v-btn>
                                </v-toolbar>

                                <v-layout row justify-center>
                                    <v-dialog
                                            v-model="addialog"
                                            persistent
                                            max-width="500"
                                    >
                                        <v-card>

                                            <v-card-title>
                                                <span class="headline">Add Download</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container grid-list-md>
                                                    <v-form :ref="`adform${item.id}`" v-model="valid" lazy-validation @submit.prevent>
                                                        <v-layout wrap>

                                                            <v-flex xs6 sm7 md7>

                                                                <v-text-field
                                                                        v-model="adform.downlabel"
                                                                        label="Link Label"
                                                                        :rules="adRules.dlabel"
                                                                        required>
                                                                </v-text-field>

                                                                <v-text-field
                                                                        v-model="adform.downlink"
                                                                        label="Link"
                                                                        :rules="adRules.dlink"
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
                                                <v-btn color="blue darken-1" flat @click="addialog = false">Close</v-btn>
                                                <v-btn color="blue darken-1" flat @click="adsubmit(`adform${item.id}`)">Add</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-dialog>
                                </v-layout>

                                <v-card-text>
                                    <div class="title">
                                        <div class="mb-4">Downloads:</div>

                                        <div v-for="(itemd, index) in item.downloads">
                                            <div class="subheading">
                                                <v-btn icon @click="openEDdialog(itemd.id, itemd.filename, itemd.download_link)" size="20" class="ma-0">
                                                    <v-icon size="20">edit</v-icon>
                                                </v-btn>

                                                <a :href="itemd.download_link" target="_blank">view</a>

                                                <v-btn icon @click="openCDPdialog(itemd.id, itemd.priority)" size="20" class="ma-0" >
                                                    <v-icon size="20">loop</v-icon>
                                                </v-btn>

                                                <v-btn icon @click="dDelete(itemd.id)" size="20" class="ma-0" >
                                                    <v-icon size="20">delete</v-icon>
                                                </v-btn>
                                                {{itemd.priority}}.{{itemd.filename}}
                                            </div>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="eddialog == itemd.id? true: false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Edit Download</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`edform${itemd.id}`" v-model="valid" lazy-validation @submit.prevent>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>

                                                                            <v-text-field
                                                                                    v-model="edform.downlabel"
                                                                                    label="Link Label"
                                                                                    :rules="edRules.dlabel"
                                                                                    required>
                                                                            </v-text-field>

                                                                            <v-text-field
                                                                                    v-model="edform.downlink"
                                                                                    label="Link"
                                                                                    :rules="edRules.dlink"
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
                                                            <v-btn color="blue darken-1" flat @click="eddialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="edsubmit(`edform${itemd.id}`, itemd.id)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="cdpdialog == itemd.id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Change the Order</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`cdpform${itemd.id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>

                                                                            <v-text-field
                                                                                    v-model="cdpform.priority"
                                                                                    :rules="cdpRules"
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
                                                            <v-btn color="blue darken-1" flat @click="cdpdialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="cdpsubmit(`cdpform${itemd.id}`, itemd.id)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                        </div>

                                    </div>
                                </v-card-text>

                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card flat class="border-success ml-2 mr-2">
                                <v-toolbar color="cyan" dark flat>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>

                                    <v-toolbar-title>Quick Links</v-toolbar-title>

                                    <v-spacer></v-spacer>

                                    <v-btn icon @click="openAQLdialog()">
                                        <v-icon>library_add</v-icon>
                                    </v-btn>
                                </v-toolbar>

                                <v-layout row justify-center>
                                    <v-dialog
                                            v-model="aqldialog"
                                            persistent
                                            max-width="500"
                                    >
                                        <v-card>

                                            <v-card-title>
                                                <span class="headline">Add Quick Link</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container grid-list-md>
                                                    <v-form :ref="`aqlform${item.id}`" v-model="valid" lazy-validation @submit.prevent>
                                                        <v-layout wrap>

                                                            <v-flex xs6 sm7 md7>

                                                                <v-text-field
                                                                        v-model="aqlform.linklabel"
                                                                        label="Link Label"
                                                                        :rules="aqlRules.llabel"
                                                                        required>
                                                                </v-text-field>

                                                                <v-text-field
                                                                        v-model="aqlform.link"
                                                                        label="Link"
                                                                        :rules="aqlRules.link"
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
                                                <v-btn color="blue darken-1" flat @click="aqldialog = false">Close</v-btn>
                                                <v-btn color="blue darken-1" flat @click="aqlsubmit(`aqlform${item.id}`)">Add</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-dialog>
                                </v-layout>

                                <v-card-text>
                                    <div class="title">
                                        <div class="mb-4">Quick Links:</div>

                                        <div v-for="(itemd, index) in item.quicklinks">
                                            <div class="subheading">
                                                <v-btn icon @click="openEQLdialog(itemd.id, itemd.link_label, itemd.link)" size="20" class="ma-0">
                                                    <v-icon size="20">edit</v-icon>
                                                </v-btn>

                                                <a :href="itemd.link" target="_blank">visit link</a>

                                                <v-btn icon @click="openCQLPdialog(itemd.id, itemd.priority)" size="20" class="ma-0" >
                                                    <v-icon size="20">loop</v-icon>
                                                </v-btn>

                                                <v-btn icon @click="qlDelete(itemd.id)" size="20" class="ma-0" >
                                                    <v-icon size="20">delete</v-icon>
                                                </v-btn>
                                                {{itemd.priority}}.{{itemd.link_label}}
                                            </div>
                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="eqldialog == itemd.id? true: false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Edit Quick Links</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`eqlform${itemd.id}`" v-model="valid" lazy-validation @submit.prevent>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>

                                                                            <v-text-field
                                                                                    v-model="eqlform.linklabel"
                                                                                    label="Link Label"
                                                                                    :rules="eqlRules.llabel"
                                                                                    required>
                                                                            </v-text-field>

                                                                            <v-text-field
                                                                                    v-model="eqlform.link"
                                                                                    label="Link"
                                                                                    :rules="eqlRules.link"
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
                                                            <v-btn color="blue darken-1" flat @click="eqldialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="eqlsubmit(`eqlform${itemd.id}`, itemd.id)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>

                                            <v-layout row justify-center>
                                                <v-dialog
                                                        v-model="cqlpdialog == itemd.id? true : false"
                                                        persistent
                                                        max-width="500"
                                                >
                                                    <v-card>

                                                        <v-card-title>
                                                            <span class="headline">Change the Order</span>
                                                        </v-card-title>

                                                        <v-card-text>
                                                            <v-container grid-list-md>
                                                                <v-form :ref="`cqlpform${itemd.id}`" v-model="valid" lazy-validation>
                                                                    <v-layout wrap>

                                                                        <v-flex xs6 sm7 md7>

                                                                            <v-text-field
                                                                                    v-model="cqlpform.priority"
                                                                                    :rules="cqlpRules"
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
                                                            <v-btn color="blue darken-1" flat @click="cqlpdialog = false">Close</v-btn>
                                                            <v-btn color="blue darken-1" flat @click="cqlpsubmit(`cqlpform${itemd.id}`, itemd.id)">Update</v-btn>
                                                        </v-card-actions>

                                                    </v-card>
                                                </v-dialog>
                                            </v-layout>


                                        </div>

                                    </div>
                                </v-card-text>

                            </v-card>
                        </v-flex>

                    </v-layout>

                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-card flat class="border-success ml-2 mr-2">
                                <v-toolbar color="cyan" dark flat>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>

                                    <v-toolbar-title>Call for Papers:</v-toolbar-title>

                                    <v-spacer></v-spacer>

                                    <v-btn icon @click="openCFPdialog()">
                                        <v-icon>library_add</v-icon>
                                    </v-btn>

                                </v-toolbar>

                                <v-layout row justify-center>
                                    <v-dialog
                                            v-model="cfpdialog"
                                            persistent
                                            max-width="500"
                                    >
                                        <v-card>

                                            <v-card-title>
                                                <span class="headline">Add Call for Paper</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container grid-list-md>
                                                    <v-form :ref="`cfpform${item.id}`" v-model="valid" lazy-validation>
                                                        <v-layout wrap>

                                                            <v-flex xs6 sm7 md7>

                                                                <v-text-field
                                                                        v-model="cfpform.topic"
                                                                        label="Topic"
                                                                        :rules="cfpRules"
                                                                        required>
                                                                </v-text-field>

                                                                <v-textarea
                                                                        v-model="cfpform.cpaper"
                                                                        label="Call for Papers"
                                                                        :rules="cfpRules"
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
                                                <v-btn color="blue darken-1" flat @click="cfpdialog = false">Close</v-btn>
                                                <v-btn color="blue darken-1" flat @click="cfpsubmit(`cfpform${item.id}`, item.id)">Add</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-dialog>
                                </v-layout>

                                <v-card-text>
                                    <v-layout row wrap>
                                        <v-flex xs12 v-for="(itemd, index) in item.cpapers" :key="itemd.id">
                                            <div class="title mb-4">
                                                <div>
                                                    <div class="mb-2">
                                                        {{itemd.topic}}

                                                        <input type="hidden" :class="`callforpaper${itemd.id}`" :value="itemd.callforpaper">

                                                        <v-btn icon @click="openCFPUdialog(itemd.id, itemd.topic, itemd.callforpaper)">
                                                            <v-icon>edit</v-icon>
                                                        </v-btn>

                                                        <v-btn icon @click.stop.prevent="copyCallforpaper(`.callforpaper${itemd.id}`)">
                                                            <v-icon>file_copy</v-icon>
                                                        </v-btn>

                                                        <v-btn icon @click.stop.prevent="cfpDelete(itemd.id)">
                                                            <v-icon>delete</v-icon>
                                                        </v-btn>
                                                      <!--  <v-btn icon>
                                                            <v-icon>library_add</v-icon>
                                                        </v-btn>-->
                                                    </div>
                                                    <div>
                                                        <span class="mb-3 subheading" v-for="(itemc, index) in itemd.callforpaper">
                                                            <v-chip label>
                                                                {{itemc}}
                                                              <!--  <v-btn icon>
                                                                    <v-icon>edit</v-icon>
                                                                </v-btn>-->
                                                            </v-chip>
                                                        </span>
                                                    </div>

                                                    <v-layout row justify-center>
                                                        <v-dialog
                                                                v-model="cfpudialog == itemd.id? true: false"
                                                                persistent
                                                                max-width="500"
                                                        >
                                                            <v-card>

                                                                <v-card-title>
                                                                    <span class="headline">Edit Call for Paper</span>
                                                                </v-card-title>

                                                                <v-card-text>
                                                                    <v-container grid-list-md>
                                                                        <v-form :ref="`cfpuform${itemd.id}`" v-model="valid" lazy-validation>
                                                                            <v-layout wrap>

                                                                                <v-flex xs6 sm7 md7>

                                                                                    <v-text-field
                                                                                            v-model="cfpuform.topic"
                                                                                            label="Topic"
                                                                                            :rules="cfpuRules"
                                                                                            required>
                                                                                    </v-text-field>

                                                                                    <v-textarea
                                                                                            v-model="cfpuform.cpaper"
                                                                                            label="Call for Papers"
                                                                                            :rules="cfpuRules"
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
                                                                    <v-btn color="blue darken-1" flat @click="cfpudialog = false">Close</v-btn>
                                                                    <v-btn color="blue darken-1" flat @click="cfpusubmit(`cfpuform${itemd.id}`, itemd.id)">Update</v-btn>
                                                                </v-card-actions>

                                                            </v-card>
                                                        </v-dialog>
                                                    </v-layout>

                                                </div>
                                            </div>
                                        </v-flex>
                                    </v-layout>

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
        name: "confedit",
        data: () => {
            return {
                id: 0,
                ebddialog: false,
                cdndialog: false,
                cddialog: false,
                cdodialog: false,
                cdpdialog: false,
                cqlpdialog: false,
                cfpdialog: false,
                cfpudialog: false,
                acddialog: false,
                aqldialog: false,
                addialog: false,
                eqldialog: false,
                eddialog: false,
                ciddialog: false,
                rdialog: false,
                cdmenu: false,
                cdomenu: false,
                acdmenu: false,
                cidmenu: false,
                cidmenu2: false,
                valid: false,
                ebdform: {
                    fullname: '',
                    title: '',
                    conftype: '',
                    city: '',
                    country: '',
                    venue: ''
                },
                cdnform: {
                    idatemenu: ''
                },
                cdform: {
                    idate: ''
                },
                acdform: {
                    idatemenu: '',
                    idate: ''
                },
                aqlform: {
                    linklabel: '',
                    link: ''
                },
                adform: {
                    downlabel: '',
                    downlink: ''
                },
                eqlform: {
                    linklabel: '',
                    link: ''
                },
                edform: {
                    downlabel: '',
                    downlink: ''
                },
                cidform: {
                  sdate: '',
                  edate: ''
                },
                cdoform: {
                    priority: ''
                },
                cdpform: {
                    priority: ''
                },
                cqlpform: {
                    priority: ''
                },
                cfpform: {
                    topic: '',
                    cpaper: ''
                },
                cfpuform: {
                    topic: '',
                    cpaper: ''
                },
                ebdRules: [
                    (v) => !!v || 'This Field is Required'
                ],
                cdnRules: [
                    (v) => !!v || 'Important date menu is Required'
                ],
                cdRules: [
                    (v) => !!v || 'Date is Required'
                ],
                cdoRules: [
                    (v) => !!v || 'Priority is Required'
                ],
                cdpRules: [
                    (v) => !!v || 'Priority is Required'
                ],
                cqlpRules: [
                    (v) => !!v || 'Priority is Required'
                ],
                acdRules: [
                    (v) => !!v || 'This Field is Required'
                ],
                aqlRules: {
                    llabel: [
                        (v) => !!v || 'link label is Required'
                    ],
                    link: [
                        (v) => !!v || 'link is Required'
                    ]
                },
                adRules: {
                    dlabel: [
                        (v) => !!v || 'download label is Required'
                    ],
                    dlink: [
                        (v) => !!v || 'download link is Required'
                    ]
                },

                eqlRules: {
                    llabel: [
                        (v) => !!v || 'link label is Required'
                    ],
                    link: [
                        (v) => !!v || 'link is Required'
                    ]
                },
                edRules: {
                    dlabel: [
                        (v) => !!v || 'download label is Required'
                    ],
                    dlink: [
                        (v) => !!v || 'download link is Required'
                    ]
                },

                cidRules: [
                    (v) => !!v || 'This Field is Required'
                ],
                cfpRules: [
                    (v) => !!v || 'This Field is Required'
                ],
                cfpuRules: [
                    (v) => !!v || 'This Field is Required'
                ]
            }
        },
        created(){
            this.id = this.$route.params.id;
        },
        mounted(){
            this.$store.dispatch('fetchProjdetails', this.id);
        },
        methods:{
            openeBDdialog(itemid, itemname, title, conftype, city, country, venue){
                this.ebddialog = true;
                this.ebdform.fullname = itemname;
                this.ebdform.title = title;
                this.ebdform.conftype = conftype;
                this.ebdform.city = city;
                this.ebdform.country = country;
                this.ebdform.venue = venue;
            },
            openCDNdialog(idmenuid, idmenu){
                this.cdndialog = idmenuid;
                this.cdnform.idatemenu = idmenu;
            },
            openCDdialog(idateid, idate){
                this.cddialog = idateid;
                this.cdform.idate = idate;
            },
            openCDOdialog(idateid, priority){
                //alert(idateid);
                this.cdodialog = idateid;
                this.cdoform.priority = priority;
            },
            openCDPdialog(did, priority){
                //alert(idateid);
                this.cdpdialog = did;
                this.cdpform.priority = priority;
            },openCQLPdialog(qlid, priority){
                //alert(idateid);
                this.cqlpdialog = qlid;
                this.cqlpform.priority = priority;
            },

            openACDdialog(){
                //alert(idateid);
                //this.$refs[form][0].reset();
                this.acddialog = true;
            },
            openAQLdialog(){
                this.aqldialog = true;
            },
            openADdialog(){
                this.addialog = true;
            },
            openEQLdialog(qlid, linklabel, link){
                this.eqldialog = qlid;
                this.eqlform.linklabel = linklabel;
                this.eqlform.link = link;
            },
            openEDdialog(did, downlabel, downlink){
                this.eddialog = did;
                this.edform.downlabel = downlabel;
                this.edform.downlink = downlink;
            },
            openCIDdialog(sdate, edate){
                this.ciddialog = true;
                this.cidform.sdate = sdate;
                this.cidform.edate = edate;
            },
            openCFPdialog(){
                this.cfpdialog = true;
            },
            openCFPUdialog(cpid, topic, cpaper){
                this.cfpudialog = cpid;
                this.cfpuform.topic = topic;
                this.cfpuform.cpaper = cpaper;
            },
            ebdsubmit(form){
                console.log(this.$refs[form][0]);
                //alert(torgid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('updateBCdetail', {id: this.id, formData: this.$data.ebdform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.ebddialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            cdnsubmit(form, idmenuid){
                console.log(this.$refs[form][0]);
                //alert(idmenuid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('UpdateCDname', {id: this.id, idmenuid, formData: this.$data.cdnform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cdndialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            cdsubmit(form, idateid){
                console.log(this.$refs[form][0]);
                //alert(idateid);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('UpdateCdate', {id: this.id, idateid, formData: this.$data.cdform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cddialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },

            cdosubmit(form, idateid){
                console.log(this.$refs[form][0]);
                //alert(this.$data.cdoform.priority);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('UpdateCDorder', {id: this.id, idateid, formData: this.$data.cdoform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cdodialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            cdpsubmit(form, did){
                console.log(this.$refs[form][0]);
                //alert(this.$data.cdoform.priority);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('UpdateCDownorder', {id: this.id, did, formData: this.$data.cdpform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cdpdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            cqlpsubmit(form, qlid){
                console.log(this.$refs[form][0]);
                //alert(this.$data.cdoform.priority);
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('UpdateQLOrder', {id: this.id, qlid, formData: this.$data.cqlpform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cqlpdialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            acdsubmit(form){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    //alert('hi..3');
                    this.$store.dispatch('loading');
                    this.$store.dispatch('addImpDate', {id: this.id, formData: this.$data.acdform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.acddialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            aqlsubmit(form){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    //alert('hi..3');
                    this.$store.dispatch('loading');
                    this.$store.dispatch('addQLinks', {id: this.id, formData: this.$data.aqlform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.aqldialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            adsubmit(form){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    //alert('hi..3');
                    this.$store.dispatch('loading');
                    this.$store.dispatch('addDownload', {id: this.id, formData: this.$data.adform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.addialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            eqlsubmit(form, qlid){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    //alert('hi..3');
                    this.$store.dispatch('loading');
                    this.$store.dispatch('updateQLinks', {id: this.id, qlid, formData: this.$data.eqlform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.eqldialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            edsubmit(form, did){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    //alert('hi..3');
                    this.$store.dispatch('loading');
                    this.$store.dispatch('updateDownload', {id: this.id, did, formData: this.$data.edform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.eddialog = false;
                    //this.closeDialog();
                    //this.$refs[form][0].reset();
                }
            },
            cidsubmit(form){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('UpdateConfDate', {id: this.id, formData: this.$data.cidform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.ciddialog = false;
                }
            },
            cfpsubmit(form){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('addCFPaper', {id: this.id, formData: this.$data.cfpform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cfpdialog = false;
                }
            },
            cfpusubmit(form, cpid){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('UpdateCFPaper', {id: this.id, cpid,  formData: this.$data.cfpuform}, ).then(() => {
                        this.$refs[form][0].reset();
                    });
                    this.cfpudialog = false;
                }
            },
            cdDelete(idmenuid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteIdate', {idmenuid, id: this.id});
            },

            cfpDelete(cfpid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteCFPaper', {cfpid, id: this.id});
            },

            qlDelete(qlid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteQLinks', {qlid, id: this.id});
            },
            dDelete(did){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteDownload', {did, id: this.id});
            },

            copyCallforpaper (cfpclass) {
                let testingCodeToCopy = document.querySelector(cfpclass);
                testingCodeToCopy.setAttribute('type', 'text');
                testingCodeToCopy.select();

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    alert('Call for paper was copied ' + msg);
                } catch (err) {
                    alert('Oops, unable to copy');
                }

                /* unselect the range */
                testingCodeToCopy.setAttribute('type', 'hidden');
                window.getSelection().removeAllRanges();
            },

        },
        computed:{
            ...mapState(['projectDetails']),
            ...mapState(['loading']),
        }
    }
</script>

<style scoped>
    .v-progress-circular{
        margin: 1rem
    }
</style>