<template>
    <v-card flat color="background">
        <v-layout row wrap>
            <v-flex md-12>
                <v-card class="ma-2 pa-2">

                    <v-card-title>
                        Blocked({{blockedUsersLength}})
                        <v-btn :disabled="selected.length <= 0" @click="activateMany(selected)">
                            <v-icon></v-icon>
                            Unblock
                        </v-btn>
                        <v-btn :disabled="selected.length <= 0" @click="deleteMany(selected)">
                            <v-icon>delete</v-icon>
                            Delete
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Search"
                                single-line
                                hide-details
                        >
                        </v-text-field>
                    </v-card-title>

                    <!--datatable-->
                    <v-data-table
                            v-model="selected"
                            :items="blocked_users"
                            :pagination.sync="pagination"
                            select-all
                            :headers="headers"
                            :search="search"
                            :loading="loading"
                    >
                        <v-progress-linear slot="progress" color="primary" indeterminate></v-progress-linear>
                        <template slot="headers" slot-scope="props">
                            <tr>
                                <th>
                                    <v-checkbox
                                            :input-value="props.all"
                                            :indeterminate="props.indeterminate"
                                            primary
                                            hide-details
                                            @click.stop.prevent="toggleAll"
                                    ></v-checkbox>
                                </th>
                                <th
                                        v-for="header in props.headers"
                                        :key="header.text"
                                        :class="['column sortable','text-xs-left', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                                        @click="changeSort(header.value)"
                                >
                                    {{ header.text }}
                                    <v-icon small>arrow_upward</v-icon>
                                </th>
                            </tr>
                        </template>
                        <template slot="items" slot-scope="props">
                            <tr :active="props.selected" @click="props.selected = !props.selected">
                                <td>
                                    <v-checkbox
                                            :input-value="props.selected"
                                            primary
                                            hide-details
                                    ></v-checkbox>
                                </td>
                                <td>
                                    <v-avatar size="35px">
                                        <img :src="props.item.pimg">
                                    </v-avatar>
                                </td>
                                <td>{{props.item.name}}</td>
                                <td>{{props.item.role}}</td>
                                <td>{{props.item.email}}</td>
                                <td>{{props.item.gender}}</td>
                                <td>
                                    <v-icon @click="deleteUser(props.item.id)">delete</v-icon>
                                </td>
                                <td>
                                    <a @click="activateUser(props.item.id)"> unblock </a>
                                </td>
                            </tr>
                        </template>
                    </v-data-table>
                    <!--/datatable-->
                </v-card>
            </v-flex>
        </v-layout>
    </v-card>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "blockedUsers",
        data: () => ({
            pagination:{
                sortBy : 'name'
            },
            search: '',
            selected: [],
            sIds:[],
            headers:[
                {text: 'Photo', value: 'pimg'},
                {text: 'Name', value: 'name'},
                {text: 'Role', value: 'role'},
                {text: 'Email', value: 'email'},
                {text: 'Gender', value: 'gender'},
                {text: 'Action', value: 'action'},
                {text: 'Activation', value: 'activation'}
            ]
        }),
        mounted(){
            this.$store.dispatch('loading');
            this.$store.dispatch('fetchblockedusers');
        },
        methods:{
            toggleAll(){
                if(this.selected.length){
                    this.selected = [];
                }
                else{
                    this.selected = this.blocked_users.slice();
                }
            },
            changeSort(column){
                if(this.pagination.sortBy === column){
                    this.pagination.descending = !this.pagination.descending
                }
                else{
                    this.pagination.sortBy = column;
                    this.pagination.descending = false;
                }
            },
            activateUser(id){
                this.$store.dispatch('loading');
                confirm('Are you sure you want activate this item..?') && this.$store.dispatch('activateUser', id);
            },
            activateMany(selected){
                for(var i=0; i<selected.length; i++){
                    this.sIds[i] = selected[i]['id'];
                }
                if(this.sIds.length > 0){
                    this.$store.dispatch('loading');
                    confirm('Are you sure want to activate selected items..?') && this.$store.dispatch('activateManyUsers', this.sIds);
                    this.selected = [];
                }
            },
            deleteUser(id){
                this.$store.dispatch('loading');
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteusers', id);
                this.selected = [];
            },
            deleteMany(selected){
                for(var i =0; i<selected.length; i++){
                    this.sIds[i] = selected[i]['id'];
                }

                if(this.sIds.length > 0){
                    this.$store.dispatch('loading');
                    confirm('Are you sure want to delete selected items..?') && this.$store.dispatch('deleteManyUsers', this.sIds);
                    this.selected = [];
                }

            }
        },

        computed: {
            ...mapState(['blocked_users']),
            ...mapState(['loading']),
            blockedUsersLength(){
                return this.blocked_users.length;
            }
        }
    }
</script>

<style scoped>

</style>