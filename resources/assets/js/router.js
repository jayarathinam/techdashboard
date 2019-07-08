
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import routes from './routes';
import StoreData from './store'

Vue.use(VueRouter);
Vue.use(Vuex);


const router = new VueRouter({
    routes,
    mode: 'history'
});



export default router;