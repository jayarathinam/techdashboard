import User from '../../components/pages/Manager/User.vue';
import addUser from '../../components/pages/Manager/addUser.vue';
import addManyUser from '../../components/pages/Manager/addManyUser.vue';
import Requests from '../../components/pages/Manager/Requests.vue'
import blockedUsers from '../../components/pages/Manager/blockedUsers.vue';
import processResults from '../../components/pages/Manager/processResults.vue';
import userDetails from '../../components/pages/Manager/userDetails.vue';

export default [
    {
        path: '/user',
        component: User,
        name: 'user',
        meta:{
            layout: 'user-management',
            requiresAuth: true,
        },
    },
    {
        path: '/user/addUser',
        component: addUser,
        name: 'addUser',
        meta:{
            layout: 'user-management',
            requiresAuth: true
        },
    },
    {
        path: '/user/addManyUser',
        component: addManyUser,
        name: 'addManyUser',
        meta:{
            layout: 'user-management',
            requiresAuth: true
        },
    },
    {
        path: '/user/requests',
        component: Requests,
        name: 'requests',
        meta:{
            layout: 'user-management',
            requiresAuth: true
        },
    },
    {
        path: '/user/blocked-users',
        component: blockedUsers,
        name: 'blockedusers',
        meta:{
            layout: 'user-management',
            requiresAuth: true
        },
    },
    {
        path: '/user/process-results',
        component: processResults,
        name: 'processresults',
        meta:{
            layout: 'user-management',
            requiresAuth: true
        },
    },
    {
        path: '/user/user-details/:id',
        component: userDetails,
        name: 'userdetails',
        meta:{
            layout: 'user-management',
            requiresAuth: true
        },
    },
];