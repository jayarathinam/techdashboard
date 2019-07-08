
import Login from '../../components/auth/Login.vue';
import Home from '../../components/pages/Home.vue';
import Projcoord from '../../components/pages/Pcoord.vue';

export default [
    {
        path: '/',
        component: Home,
        name: 'home',
        meta:{
            layout: 'auth',
            requiresAuth: true
        }
    },
    {
        path: '/projcoord',
        component: Projcoord,
        name: 'projcoord',
        meta:{
            layout: 'auth',
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta:{
            permission: 'guest',
            fail: '404.html'
        }
    }
];