<template>
    <div id="#app">
        <component :is="layout">
            <router-view/>
        </component>
    </div>
</template>

<script>

    const nauth_layout = 'non-auth';

    export default {
        name: "App",
        computed:{
            layout(){

                if(this.$route.meta.layout == 'user-management'){
                    return 'user-management-layout'
                }

                else if(this.$route.meta.layout == 'pc-project-management'){
                    return 'pc-project-management-layout'
                }

                else{
                    return nauth_layout +'-layout';
                }

                return (this.$route.meta.layout || nauth_layout)+ '-layout';
            }
        }
    }
</script>

<style scoped>

</style>