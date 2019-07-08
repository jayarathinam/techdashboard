<template>
    <v-app>
        <v-container>
            <v-layout>
                <v-flex xs12 sm4 offset-sm4>
                    <v-card style="min-height: 500px;">
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
                            <v-flex md8 offset-md2>

                               <v-card flat>
                                   <v-card-text class="pa-2">
                                       <h2 class="text-md-center">Sign into Techadmin</h2>
                                   </v-card-text>
                                   <v-card-text class="pa-2">
                                       <p class="text-md-center">Please Sign into techadmin to access your profile.
                                           Please echadmin to access your profile.
                                           Please Sign into techadmin to \ profile.</p>
                                   </v-card-text>
                               </v-card>

                                <v-form @submit.prevent="authenticate" ref="form" v-model="valid" lazy-validation>

                                    <v-text-field
                                            label="Email"
                                            name="email"
                                            v-model="form.email"
                                            :rules="emailRules"
                                    >
                                    </v-text-field>

                                    <v-text-field
                                            label="Password"
                                            name="password"
                                            v-model="form.password"
                                            :append-icon="show? 'visibility_off' : 'visibility'"
                                            :rules="passwordRules"
                                            :type="show? 'text' : 'password' "
                                            @click:append="show = !show"
                                    >
                                    </v-text-field>

                                    <v-btn type="submit" :disabled="!valid" color="primary" :loading="loading">
                                        Login
                                    </v-btn>
                                    <v-btn @click="clear">clear</v-btn>
                                    <v-btn @click="clear">Request Account</v-btn>

                                </v-form>
                            </v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-app>
</template>

<script>
    import {login} from '../../helpers/auth';

    export default {
        name: "login",
        data: () => ({
            valid: true,
            show: false,
            loading: null,
            form: {
                email: '',
                password: ''
            },
            emailRules: [
                v => !!v || 'Email is required',
                v => /.+@.+/.test(v) || 'Email must be valid',
            ],
            passwordRules: [
                v => !!v || 'Password is required',
            ],
        }),
        methods:{
            authenticate(){

                if (this.$refs.form.validate()) {
                    this.loading = true;

                    this.$store.dispatch('login');

                    login(this.$data.form)
                        .then((res) => {
                            this.loading = false;
                            this.$store.commit('loginSuccess', res);

                            //alert(this.$store.state.currentUser.role);

                            switch(this.$store.state.currentUser.role){
                                case 'manager':
                                    this.$router.push({path: '/'});
                                    break;
                                case 'project co-ordinator':
                                    this.$router.push({path: '/projcoord'});
                                    break;
                            }

                        })
                        .catch((error) => {
                            this.loading = false;
                            this.$store.commit('loginFailed', {error})
                        });
                }
            },
            clear(){
                this.$refs.form.reset()
            }
        },
        computed: {
            authError(){
                return this.$store.getters.authError;
            }
        }
    }
</script>

<style scoped>

</style>