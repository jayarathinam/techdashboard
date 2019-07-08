<template>
    <v-container>
        <v-layout row>
            <v-flex xs12 sm6 offset-sm3>

                <v-card class="mx-auto" max-width="500">
                    <template>
                        <v-progress-linear
                                v-if="loading"
                                :indeterminate="loading"
                                height="3px"
                        >
                        </v-progress-linear>
                        <div style="height: 3px; margin: 1rem" v-else></div>
                    </template>


                    <v-card-title class="title font-weight-regular justify-space-between">
                        <span>Add-user [{{currentTitle}}]</span>
                        <v-avatar
                                color="primary lighten-2"
                                class="subheading white--text"
                                size="24"
                                v-text="step"
                        >
                        </v-avatar>
                    </v-card-title>

                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-window v-model="step">
                            <v-window-item :value="1">
                                <v-layout>
                                    <v-flex md8 offset-md2>
                                        <v-form ref="form1">

                                            <v-layout>
                                                <v-flex xs2>
                                                    <v-switch v-model="usermode" value="activated">
                                                    </v-switch>
                                                </v-flex>
                                                <v-flex xs5>
                                                    <v-text-field
                                                            label="User Mode"
                                                            :value="usermode? 'Guest Mode' : 'Employee Mode'"
                                                    >
                                                    </v-text-field>
                                                </v-flex>
                                                <v-flex xs4 offset-xs1>
                                                    <v-btn :to="{path: '/user/addManyUser'}">Bulk Upload</v-btn>
                                                </v-flex>
                                            </v-layout>

                                            <v-text-field
                                                    label="Name"
                                                    name="name"
                                                    v-model = "form.name"
                                                    :rules="nameRules"
                                            >
                                            </v-text-field>

                                            <v-select
                                                    :items="genders"
                                                    label="Gender"
                                                    name="gender"
                                                    v-model="form.gender"
                                                    :rules="genderRules"
                                            >
                                            </v-select>

                                            <v-menu
                                                    :close-on-content-click="false"
                                                    v-model="menu2"
                                                    :nudge-right="40"
                                                    lazy
                                                    transition="scale-transition"
                                                    offset-y
                                                    full-width
                                                    min-width="290px"
                                            >
                                                <v-text-field
                                                        slot="activator"
                                                        v-model="form.dob"
                                                        :rules="dobRules"
                                                        label="Date of Birth"
                                                        append-icon="cake"
                                                        readonly
                                                ></v-text-field>
                                                <v-date-picker v-model="form.dob" @input="menu2 = false"></v-date-picker>
                                            </v-menu>
                                        </v-form>
                                    </v-flex>
                                </v-layout>
                            </v-window-item>

                            <v-window-item :value="2">
                                <v-layout>
                                    <v-flex md8 offset-md2>

                                        <v-form ref="form2">
                                            <v-select
                                                    :items="roles"
                                                    label="Role"
                                                    name="role"
                                                    v-model="form.role"
                                                    :rules="roleRules"
                                            >
                                            </v-select>

                                            <v-text-field
                                                    label="Email address"
                                                    name = "email"
                                                    v-model="form.email"
                                                    :rules="emailRules"
                                                    value="example"
                                            >
                                            </v-text-field>

                                            <v-text-field
                                                    label="Password"
                                                    name="password"
                                                    v-model="form.password"
                                                    :rules="passwordRules"
                                                    hint="It should be a minimum of 6 characters"
                                                    :append-icon="showpass? 'visibility_off' : 'visibility'"
                                                    :type="showpass? 'text' : 'password' "
                                                    @click:append="showpass = !showpass"
                                            >
                                            </v-text-field>

                                            <v-text-field
                                                    label="Confirm Password"
                                                    name="cpassword"
                                                    v-model="form.password_confirmation"
                                                    :rules="cpasswordRules"
                                                    :errorMessages="(form.password_confirmation == '') || (form.password == form.password_confirmation) ? '' : 'password does not match'"
                                                    :append-icon="showcpass? 'visibility_off' : 'visibility'"
                                                    :type="showcpass? 'text' : 'password'"
                                                    @click:append="showcpass = !showcpass"
                                            >
                                            </v-text-field>
                                        </v-form>

                                    </v-flex>
                                </v-layout>
                            </v-window-item>

                            <v-window-item :value="3">
                                <v-layout>
                                        <v-flex xs8 offset-xs2>

                                        <v-form ref="form3">

                                            <v-layout row>
                                                <v-flex md7>
                                                    <v-text-field
                                                            label="Upload Profile Picture"
                                                            @click="pickFile"
                                                            v-model="imageName"
                                                            :rules="imageRules"
                                                            hint="This is not required"
                                                            prepend-icon="camera"
                                                    >
                                                    </v-text-field>
                                                    <input
                                                            type="file"
                                                            style="display:none"
                                                            ref="image"
                                                            accept="image/*"
                                                            @change="onFilePicked"
                                                    >
                                                </v-flex>
                                                <v-flex md5 class="text-xs-center">
                                                    <v-avatar size="100px">
                                                        <img :src="form.imageFile? form.imageFile : '/images/admin.png'" height="100">
                                                    </v-avatar>
                                                </v-flex>

                                            </v-layout>

                                            <v-layout row>
                                                <v-flex xs2>
                                                    <v-switch v-model="form.auth" value="activated">
                                                    </v-switch>
                                                </v-flex>
                                                <v-flex xs6>
                                                    <v-text-field
                                                            label="User Add Status"
                                                            :value="form.auth? 'Direct Add' : 'Request'"
                                                    >
                                                    </v-text-field>
                                                </v-flex>
                                            </v-layout>

                                        </v-form>


                                    </v-flex>
                                </v-layout>
                            </v-window-item>

                        </v-window>
                    </v-form>



                    <v-card-actions>
                        <v-btn
                                :disabled="step === 1"
                                flat
                                @click="step--"
                        >
                            Back
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                                v-if="step === 3"
                                color="primary"
                                depressed
                                @click="next()"
                        >
                            Add
                        </v-btn>

                        <v-btn
                                v-else
                                color="primary"
                                depressed
                                @click="next()"
                        >
                            Next
                        </v-btn>
                    </v-card-actions>

                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {addUser} from '../../../helpers/user'
    import { mapState } from 'vuex';
    import { Validator } from 'vee-validate';

    export default {
        name: "addUser",

        data: () => ({
            valid: true,
            errormsg: '',
            usermode: '',
            showpass:false,
            showcpass: false,
            step: 1,
            genders: ['Male','Female','Transgender'],
            roles: ['Manager','Web Developer','Web Designer','Graphic Designer','Seo Analyst','Project Manager','Data Entry','External'],
            menu: false,
            modal: false,
            menu2: false,
            imageName : '',
            imageUrl: '',
            imageFile: '',

            form:{
                name: '',
                gender: '',
                dob: '',
                role: '',
                email: '',
                password: '',
                password_confirmation:'',
                imageFile: '',
                auth: ''
            },



            /**rules**/
            nameRules:[
                (v) => !!v || 'Name is Required'
            ],
            genderRules:[
                (v) => !!v || 'Gender is Required'
            ],
            dobRules:[
                (v) => !!v || 'Date of Birth is Required'
            ],
            roleRules:[
                (v) => !!v || 'Role is Required'
            ],
            emailRules:[
                (v) => !!v || 'Email is Required',
                (v) => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
            ],
            EemailRules:[
                (v) => !!v || 'Email is Required',
            ],
            passwordRules:[
                (v) => !!v || 'Password is Required'
            ],
            cpasswordRules:[
                (v) => !!v || 'Password Confirmation is Required'
            ],
            imageRules:[
            ]
            /**eof rules**/
        }),
        computed: {
            ...mapState(['loading']),
            ...mapState(['blocked_users']),
            currentTitle() {
                switch (this.step) {
                    case 1:
                        return 'Personal-Informations'
                    case 2:
                        return 'Official-Informations'
                    case 3:
                        return 'Upload-Profile-Picture'
                }
            },
        },
        methods:{
            pickFile(){
                this.$refs.image.click();
            },

            next(){

                if(this.step == 1){
                    if(this.$refs.form1.validate()){
                        this.step++;
                    }
                }

                else if(this.step == 2){
                    if(this.$refs.form2.validate()){
                        this.step++;
                    }
                }
                else{
                    if(this.$refs.form3.validate()){
                        this.$store.dispatch('loading');
                        this.$store.dispatch('insertuser', this.$data.form);
                        this.$router.push({path: '/user'});
                    }
                }

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
            }
        },

    }
</script>

<style scoped>

</style>