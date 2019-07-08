<template>
    <v-app>
        <AuthLayout/>
        <v-content>
            <slot/>
        </v-content>
    </v-app>
</template>

<script>
    import AuthLayout from '../../Authenticated.vue'
    import VContent from "vuetify/lib/components/VGrid/VContent";

    export default {
        name: "ProjectManagement",
        components:{
            VContent,
            AuthLayout : AuthLayout
        }
    }
</script>

<style scoped>

</style>