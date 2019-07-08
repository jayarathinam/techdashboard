<template>

    <v-card flat color="background">
        <v-layout row wrap>
            <v-flex md-12>
                <v-card class="ma-2 pa-2">

                    <v-card-title>
                        Users({{usersLength}})
                        <v-btn :disabled="selected.length <= 0" @click="deleteMany(selected)">
                            <v-icon>delete</v-icon>
                            Delete
                        </v-btn>
                        <v-btn :disabled="selected.length <= 0" @click="blockMany(selected)">
                            <v-icon>block</v-icon>
                            Block
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

                    <v-data-table
                            v-model="selected"
                            :items="users"
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
                            <tr :active="props.selected">
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
                                <td><v-icon @click="deleteUser(props.item.id)">delete</v-icon></td>
                                <td>
                                    <a @click="blockUser(props.item.id)">Block</a>
                                </td>
                                <td>
                                    <a :href="'user/user-details/'+ props.item.id">Details</a>
                                </td>
                            </tr>
                        </template>
                    </v-data-table>

                </v-card>
            </v-flex>
        </v-layout>

    </v-card>

</template>

<script>
    import { mapState } from 'vuex';


    export default {
        name: "User",
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
                {text: 'Action 2', value: 'action 2'},
                {text: 'Action 3', value: 'action 3'}
            ]
        }),
        mounted(){
            this.$store.dispatch('loading');
            this.$store.dispatch('fetchusers');
            this.$store.dispatch('fetchblockedusers');
        },

        methods:{
            toggleAll(){
                if(this.selected.length){
                    this.selected = [];
                }
                else{
                    this.selected = this.users.slice();
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
            blockUser(id){
                this.$store.dispatch('loading');
                confirm('Are you sure you want to block this user..?') && this.$store.dispatch('blockUser', id);
                this.selected = [];
            },
            blockMany(selected){
                for(var i =0; i<selected.length; i++){
                    this.sIds[i] = selected[i]['id'];
                }

                if(this.sIds.length > 0){
                    this.$store.dispatch('loading');
                    confirm('Are you sure want to block selected users..?') && this.$store.dispatch('blockManyUsers', this.sIds);
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
            ...mapState(['users']),
            ...mapState(['blocked_users']),
            ...mapState(['loading']),
            usersLength(){
                if(!this.search){
                    return this.users.length;
                }
                else{
                    this.itemsLength;
                }
            },
            blockedUsersLength(){
                return this.blocked_users.length;
            }
        }
    }
</script>

<style scoped>

</style>