<template>
        <v-card color="background">
                <Toolbar/>
                <Navside/>
        </v-card>
</template>

<script>
    import toolbar from '../../components/Layoutobjects/Toolbar.vue';
    import navdrawer from '../../components/Layoutobjects/NavDrawer.vue';
    import VApp from "vuetify/lib/components/VApp/VApp";

    export default {
        name: "Authenticated",
        components: {
            VApp,
            Toolbar: toolbar,
            Navside: navdrawer
        },
        mini:false
    }
</script>

<style scoped>

</style>