<template>
    <AuthLayout/>
</template>

<script>
   import AuthLayout from '../Layouts/Authenticated.vue'
    export default {
        name: "Home",
        components :{
            AuthLayout : AuthLayout
        }
    }
</script>

<style scoped>

</style>