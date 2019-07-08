
import Vue from 'vue';
import router from './router'
import StoreData from './store';
import App from './components/App.vue';
import VeeValidate from 'vee-validate';
import Vuetify from 'vuetify/es5/components/Vuetify';
import VApp from 'vuetify/es5/components/VApp';
import VIcon from 'vuetify/es5/components/VIcon';
import VBtn from 'vuetify/es5/components/VBtn';
import VToolbar from 'vuetify/es5/components/VToolbar';
import VGrid from 'vuetify/es5/components/VGrid';
import VNavigationDrawer from 'vuetify/es5/components/VNavigationDrawer';
import VList from 'vuetify/es5/components/VList';
import VBreadcrumbs from 'vuetify/es5/components/VBreadcrumbs';
import VAvatar from 'vuetify/es5/components/VAvatar';
import VBadge from 'vuetify/es5/components/VBadge';
import VTextField from 'vuetify/es5/components/VTextField';
import VSelect from 'vuetify/es5/components/VSelect';
import VDatePicker from 'vuetify/es5/components/VDatePicker';
import VCheckbox from 'vuetify/es5/components/VCheckbox';
import VTextarea from 'vuetify/es5/components/VTextarea';
import VHover from 'vuetify/es5/components/VHover';
import VProgressCircular from 'vuetify/es5/components/VProgressCircular';
import VExtran from 'vuetify/es5/components/';
import VForm from 'vuetify/es5/components/VForm';
import VMenu from 'vuetify/es5/components/VMenu'
import VCard from 'vuetify/es5/components/VCard';
import VChip from 'vuetify/es5/components/VChip';
import VProgressLinear from 'vuetify/es5/components/VProgressLinear';
import VDataTable from 'vuetify/es5/components/VDataTable';
import VWindow from 'vuetify/es5/components/VWindow';
import VSwitch from 'vuetify/es5/components/VSwitch';
import VImg from 'vuetify/es5/components/VImg';
import VDialog from 'vuetify/es5/components/VDialog';
import VAutoComplete from 'vuetify/es5/components/VAutocomplete';
import VDivider from 'vuetify/es5/components/VDivider';
import Vuex from 'vuex';

import ALayout from './components/Layouts/Authenticated.vue';
import NAlayout from './components/Layouts/NonAuthenticated.vue';
import UMlayout from './components/Layouts/Authenticated/manager/UserManagement.vue';
import PCPMlayout from './components/Layouts/Authenticated/projcoord/ProjectManagement.vue';

Vue.use(Vuetify,{
    components:{
        VApp,
        VBtn,
        VIcon,
        VToolbar,
        VGrid,
        VNavigationDrawer,
        VList,
        VBreadcrumbs,
        VAvatar,
        VBadge,
        VForm,
        VMenu,
        VTextField,
        VDatePicker,
        VSelect,
        VCheckbox,
        VTextarea,
        VHover,
        VProgressCircular,
        VCard,
        VChip,
        VProgressLinear,
        VDataTable,
        VWindow,
        VSwitch,
        VImg,
        VDialog,
        VAutoComplete,
        VDivider
    },
    theme:{
        primary: '#58d8a3',
        error: '#FF0000',
        mback: '#fafafa',
        stitle: '#59adde',
        dbluebutton: '#1496bc',
    }
});

Vue.component('auth-layout',ALayout);
Vue.component('non-auth-layout',NAlayout);
Vue.component('user-management-layout',UMlayout);
Vue.component('pc-project-management-layout',PCPMlayout);

Vue.use(VeeValidate);

const store = new Vuex.Store(StoreData);


router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const currentUser = store.state.currentUser;

    if(requiresAuth && !currentUser){
        next('/login');
    }
    else if(to.path == '/login' && currentUser){
        next('/')
    }
    else{
        next();
    }
});

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
