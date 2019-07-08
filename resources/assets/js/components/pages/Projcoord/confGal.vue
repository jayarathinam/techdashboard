<template>
    <v-card color="mback" flat>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card class="ma-4 pa-2" flat v-for="(item, index) in projectDetails" :key="item.id">
                    <!--{{item.galleries}}-->
                    <v-btn color="black" dark @click="openACGDialog()">
                        <v-icon dark left>library_add</v-icon>Add Conference Gallery
                    </v-btn>

                    <v-layout row justify-center>
                        <v-dialog
                                v-model="acgdialog"
                                persistent
                                max-width="500"
                        >
                            <v-card>

                                <v-card-title>
                                    <span class="headline">Add Gallery</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-form :ref="`acgform${item.id}`" v-model="valid" lazy-validation>
                                            <v-layout wrap>

                                                <v-flex xs6 sm7 md10>

                                                    <v-text-field
                                                            v-model="acgform.gtitle"
                                                            label="Title"
                                                            :rules="acgRules"
                                                            required>
                                                    </v-text-field>

                                                    <div v-show="!images.length">
                                                        <div class="uploader"
                                                             @dragenter="OnDragEnter"
                                                             @dragleave="OnDragLeave"
                                                             @dragover.prevent
                                                             @drop="OnDrop"
                                                             :class="{ dragging: isDragging}"
                                                        >
                                                            <v-icon size="100">backup</v-icon>
                                                            <p>Drag your Images here</p>
                                                            <div>OR</div>
                                                            <div class="file-input">
                                                                <label for="file">Select a File</label>
                                                                <input type="file" id="file" @change="OnInputChange" multiple/>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="images-preview" v-show="images.length">
                                                        <v-layout row wrap>
                                                            <v-flex xs4 v-for="(image, index) in images" :key="index">
                                                                <v-img :src="image"></v-img>
                                                            </v-flex>
                                                        </v-layout>
                                                    </div>

                                                </v-flex>

                                                <v-flex xs6 sm5 md5>

                                                </v-flex>

                                            </v-layout>
                                        </v-form>
                                    </v-container>
                                </v-card-text>


                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" flat @click="acgdialog = false">Close</v-btn>
                                    <v-btn color="blue darken-1" flat @click="acgsubmit(`acgform${item.id}`, item.id)">Add</v-btn>
                                </v-card-actions>

                            </v-card>
                        </v-dialog>
                    </v-layout>

                    <v-layout row wrap>
                        <v-flex xs12 v-for="(itemd, index) in item.galleries" :key="item.id">
                            <v-card flat class="border-success ml-2 mr-2">
                                <v-toolbar color="cyan" dark flat>
                                    <v-toolbar-side-icon></v-toolbar-side-icon>

                                    <v-toolbar-title>{{ itemd.gallery_title }}</v-toolbar-title>


                                    <v-spacer></v-spacer>

                                    <v-btn icon>
                                        <v-icon @click="openACIDialog(itemd.id)">library_add</v-icon>
                                    </v-btn>

                                    <v-btn icon>
                                        <v-icon @click="">edit</v-icon>
                                    </v-btn>

                                    <v-btn icon>
                                        <v-icon @click="gDelete(itemd.id)">delete</v-icon>
                                    </v-btn>

                                </v-toolbar>

                                <v-layout row justify-center>
                                    <v-dialog
                                            v-model="acidialog == itemd.id? true: false"
                                            persistent
                                            max-width="500"
                                    >
                                        <v-card>

                                            <v-card-title>
                                                <span class="headline">Add images to  {{itemd.gallery_title}}</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container grid-list-md>
                                                    <v-form :ref="`aciform${itemd.id}`" v-model="valid" lazy-validation>
                                                        <v-layout wrap>

                                                            <v-flex xs6 sm7 md10>

                                                                <div v-show="!images.length">
                                                                    <div class="uploader"
                                                                         @dragenter="OnDragEnter"
                                                                         @dragleave="OnDragLeave"
                                                                         @dragover.prevent
                                                                         @drop="OnDrop2"
                                                                         :class="{ dragging: isDragging}"
                                                                    >
                                                                        <v-icon size="100">backup</v-icon>
                                                                        <p>Drag your Images here</p>
                                                                        <div>OR</div>
                                                                        <div class="file-input">
                                                                            <label for="file">Select a File</label>
                                                                            <input type="file" id="file2" @change="OnInputChange2" multiple/>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="images-preview" v-show="images.length">
                                                                    <v-layout row wrap>
                                                                        <v-flex xs4 v-for="(image, index) in images" :key="index">
                                                                            <v-img :src="image"></v-img>
                                                                        </v-flex>
                                                                    </v-layout>
                                                                </div>

                                                            </v-flex>

                                                            <v-flex xs6 sm5 md5>

                                                            </v-flex>

                                                        </v-layout>
                                                    </v-form>
                                                </v-container>
                                            </v-card-text>


                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" flat @click="acidialog = false">Close</v-btn>
                                                <v-btn color="blue darken-1" flat @click="acisubmit(`aciform${itemd.id}`, itemd.id)">Add</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-dialog>
                                </v-layout>


                                <v-card-text>
                                    <v-container grid-list-sm fluid>
                                        <v-layout row wrap>
                                            <v-flex v-for="(itemgal, index) in itemd.gallery" :key="index" xs2 d-flex>

                                                <v-card>
                                                    <v-img
                                                            :src="itemgal"
                                                            :lazy-src="itemgal"
                                                            aspect-ratio="1"
                                                            class="grey lighten-2"
                                                    >
                                                        <template v-slot:placeholder>
                                                            <v-layout
                                                                    fill-height
                                                                    align-center
                                                                    justify-center
                                                                    ma-0
                                                            >
                                                                <!--<v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>-->
                                                            </v-layout>
                                                        </template>
                                                    </v-img>

                                                    <v-card-text class="text-xs-center">

                                                        <v-btn icon>
                                                            <v-icon @click="giDelete(itemd.id, itemgal)">delete</v-icon>
                                                        </v-btn>

                                                    </v-card-text>

                                                </v-card>


                                               <!-- <v-card flat tile class="d-flex">
                                                    <v-img
                                                            :src="itemgal"
                                                            :lazy-src="itemgal"
                                                            aspect-ratio="1"
                                                            class="grey lighten-2"
                                                    >
                                                        <template v-slot:placeholder>
                                                            <v-layout
                                                                    fill-height
                                                                    align-center
                                                                    justify-center
                                                                    ma-0
                                                            >
                                                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                                            </v-layout>
                                                        </template>
                                                    </v-img>
                                                </v-card>-->


                                            </v-flex>
                                        </v-layout>
                                    </v-container>

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
        name: "confGal",
        data: () => {
            return{
                id: 0,
                acgdialog: false,
                acidialog: false,
                isDragging: false,
                dragCount: 0,
                images: [],
                files: [],
                valid: false,
                acgform: {
                    gtitle : '',
                    images : []
                },
                aciform: {
                    images : []
                },
                acgRules: [
                    (v) => !!v || 'This Field is Required'
                ],
                aciRules: [
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
        methods: {
            OnDragEnter(e){
                e.preventDefault();
                this.dragCount++;
                this.isDragging = true;

                //console.log('entered');
            },
            OnDragLeave(e){
                e.preventDefault();
                this.dragCount-- ;

                if(this.dragCount <= 0){
                    this.isDragging = false;
                }

            },
            OnInputChange(e){
                const files = e.target.files;

                Array.from(files).forEach(file => this.addImage(file));
            },
            OnInputChange2(e){
                const files = e.target.files;

                Array.from(files).forEach(file => this.addImage2(file));
            },
            OnDrop(e){
                e.preventDefault();
                e.stopPropagation();

                this.isDragging = false;
                const files = e.dataTransfer.files;

                Array.from(files).forEach(file => this.addImage(file));
            },
            OnDrop2(e){
                e.preventDefault();
                e.stopPropagation();

                this.isDragging = false;
                const files = e.dataTransfer.files;

                Array.from(files).forEach(file => this.addImage2(file));
            },
            addImage(file){
                if(!file.type.match('image.*')){
                    console.log(`${file.name} is not an image`);
                    return;
                }

                this.files.push(file);

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.images.push(e.target.result);
                    this.acgform.images.push(e.target.result);
                };
                reader.readAsDataURL(file);
            },
            addImage2(file){
                if(!file.type.match('image.*')){
                    console.log(`${file.name} is not an image`);
                    return;
                }

                this.files.push(file);

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.images.push(e.target.result);
                    this.aciform.images.push(e.target.result);
                };
                reader.readAsDataURL(file);
            },
            openACGDialog(){
                this.acgdialog = true;
            },
            openACIDialog(gid){
                this.acidialog = gid;
            },
            acgsubmit(form){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('addCGallery', {id: this.id, formData: this.$data.acgform}, ).then(() => {
                        this.$refs[form][0].reset();
                        this.images = [];
                        this.acgform.images = [];
                        this.files = [];
                    });
                    this.acgdialog = false;
                }
            },
            acisubmit(form, gid){
                console.log(this.$refs[form][0].validate());
                if(this.$refs[form][0].validate()){
                    this.$store.dispatch('loading');
                    this.$store.dispatch('addCImages', {id: this.id, gid, formData: this.$data.aciform}, ).then(() => {
                        this.$refs[form][0].reset();
                        this.images = [];
                        this.aciform.images = [];
                        this.files = [];
                    });
                    this.acidialog = false;
                }
            },
            gDelete(gid){
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteGallery', {gid, id: this.id});
            },
            giDelete(gid, gname){
                //alert(gid+' '+gname);
                confirm('Are you sure you want to delete this item..?') && this.$store.dispatch('deleteGImage', {gid, gname, id: this.id});
            },
        },
        computed: {
            ...mapState(['projectDetails']),
        }
    }
</script>

<style lang="scss" scoped>
    .uploader{
        width: 100%;
        background: #f7f7f7;
        padding: 40px 15px;
        text-align: center;
        border-radius: 10px;
        border: 3px dashed #fff;

        &.dragging{
            background: #fff;
            color: #2196f3;
            border: 3px dashed #2196f3;
        }
    }
</style>