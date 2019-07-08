
import myProjects from '../../components/pages/Projcoord/myprojects.vue';
import projectDetails from '../../components/pages/Projcoord/projectDetails.vue';
import CMS from '../../components/pages/Projcoord/cms.vue';
import cmsmenu from '../../components/pages/Projcoord/cmsmenu.vue';
import confEdit from '../../components/pages/Projcoord/confedit.vue';
import confReg from '../../components/pages/Projcoord/confreg.vue';
import addCont from '../../components/pages/Projcoord/addCont.vue';
import confGal from '../../components/pages/Projcoord/confGal.vue';

export default [
    {
        path : '/projcoord/myprojects',
        component : myProjects,
        name : 'myProjects',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
    {
        path : '/projcoord/myprojects/:id',
        component : projectDetails,
        name : 'projectDetails',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
    {
        path : '/projcoord/myprojects/:id/cms',
        component : CMS,
        name : 'cms',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
    {
        path : '/projcoord/myprojects/:id/cmsmenu',
        component : cmsmenu,
        name : 'cmsmenu',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
    {
        path : '/projcoord/myprojects/:id/confedit',
        component : confEdit,
        name : 'confedit',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
    {
        path : '/projcoord/myprojects/:id/confreg',
        component : confReg,
        name : 'confreg',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
    {
        path : '/projcoord/myprojects/:id/addcontedit',
        component : addCont,
        name : 'addCont',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
    {
        path : '/projcoord/myprojects/:id/galleryedit',
        component : confGal,
        name : 'confGal',
        meta :{
            layout : 'pc-project-management',
            requiresAuth: true,
        }
    },
];