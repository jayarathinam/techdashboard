import {getLocalUser} from './helpers/auth';
import axios from 'axios';
import {users, projects} from './api';
import router from './router'

const user = getLocalUser();

export default {
    state:{
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        resvalue: false,
        mini: false,
        auth_error: null,
        techUsers: [],
        users: [],
        blocked_users: [],
        requests: [],
        current_error: [],
        csvError: [],
        user_details: [],
        projectDetails:[],
        ocm:[],
        regDetails: [],
        projectbyUser: []
    },
    getters:{
        isLoading(state){
            return state.loading;
        },
        isLoggedIn(state){
            return state.isLoggedIn;
        },
        currentUser(state){
            return state.currentUser;
        },
        authError(state){
            return state.auth_error;
        },
        techUsers(state){

        }
    },
    mutations:{
        login(state){
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload){
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem('user',JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload){
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state){
            localStorage.removeItem('user');
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        FetchUsers(state, users){
            state.users = users;
            state.loading = false;
        },
        FetchRequests(state, requests){
            state.requests = requests;
            state.loading = false;
        },
        UserDetails(state, userDetails){
            state.user_details = userDetails;
            state.loading = false;
        },
        projectDetails(state, projectDetails){
            state.projectDetails = projectDetails;
            state.loading = false;
        },
        Ocm(state, ocm){
            state.ocm = ocm;
            state.loading = false;
        },
        Registration(state, regDetails){
            state.regDetails = regDetails;
            state.loading = false;
        },
        BlockedUsers(state, blocked_users){
            state.blocked_users = blocked_users;
            state.loading = false;
        },
        ProjectbyUser(state, projectbyuser){
            state.projectbyUser = projectbyuser;
            state.loading = false;
        },
        currentError(state, currentError){
            state.current_error = currentError;
            state.loading = false;
        },
        csvError(state, csvError){
            state.csvError = csvError;
            state.loading = false;
        },
        loading(state){
            state.loading = true;
        },
        resvalue(state){
            state.resvalue = true;
        }
    },

    actions:{
        login(context){
            context.commit('login');
        },
        loading(context){
            context.commit('loading');
        },
        fetchusers({commit}){
            return axios.get(users)
                .then(response => commit('FetchUsers', response.data))
                .catch()
        },
        fetchblockedusers({commit}){
            return axios.get(`${users}/blockedusers`)
                .then(response => commit('BlockedUsers', response.data))
                .catch()
        },
        fetchrequests({commit}){
            return axios.get(`${users}/requests`)
                .then(response => commit('FetchRequests', response.data))
                .catch()
        },
        insertuser({commit}, formdata){
            axios.post(users, formdata)
                .then(response => {
                    commit('FetchUsers', response.data);
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch()
        },
        insertManyUsers({commit}, formdata){
            axios.post(`${users}/bulkupload`, formdata)
                .then(response => {
                    alert(response.data);
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch(error => {
                    //alert('error');
                    commit('currentError', error.response.data.errors);
                })
        },
        userDetails({commit}, id){
            return axios.get(`${users}/getuser/${id}`, id)
                .then(response => {
                    commit('UserDetails', response.data)
                })
                .catch()
        },
        processUsersCsv({commit}, formdata){
            axios.post(`${users}/process`, formdata)
                .then(response => {
                    commit('csvError', response.data);
                    router.push('/user/process-results');
                })
                .catch(error => {
                    commit('csvError', error.response.data.errors);
                    router.push('/user/process-results');
                })
        },
        activateUser({}, id){
            axios.post(`${users}/activate/${id}`)
                .then(() => {
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch();
        },
        activateManyUsers({}, ids){
            axios.post(`${users}/activate/${ids}`)
                .then(() => {
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch();
        },
        blockUser({}, id){
            axios.post(`${users}/block/${id}`)
                .then(() => {
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch();
        },
        blockManyUsers({}, ids){
            axios.post(`${users}/block/${ids}`)
                .then(() => {
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch();
        },
        deleteusers({}, id){
            axios.delete(`${users}/${id}`)
                .then(() => {
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch();
        },
        deleteManyUsers({}, ids){
            axios.delete(`${users}/${ids}`,)
                .then(() => {
                    this.dispatch('fetchusers');
                    this.dispatch('fetchblockedusers');
                    this.dispatch('fetchrequests');
                })
                .catch();
        },

        fetchProjectsbyUser({commit}, userId){
            axios.get(`${projects}/${userId}`)
                .then(response => {
                    //alert(response.data);
                    commit('ProjectbyUser', response.data);
                })
                .catch();
        },
        fetchProjdetails({commit}, projId){
            axios.get(`${projects}/getproj/${projId}`)
                .then(response => {
                    //alert(response.data.projdetails);
                    commit('projectDetails', response.data.projdetails);
                    //router.push('/projcoord/myprojects/:name');
                })
                .catch();
        },
        fetchOcmdetails({commit}, projId){
            axios.get(`${projects}/getocm/${projId}`)
                .then(response => {
                    //alert(response.data.projdetails);
                    commit('Ocm', response.data.ocms);
                    //router.push('/projcoord/myprojects/:name');
                })
                .catch();
        },
        fetchRegdetails({commit}, projId) {
            axios.get(`${projects}/getreg/${projId}`)
                .then(response => {
                    //alert(response.data.projdetails);
                    commit('Registration', response.data);
                    //router.push('/projcoord/myprojects/:name');
                })
                .catch();
        },
        addRCategory({commit}, {id, regsmenuid, regmenuid, formData}){
            //alert(id);
            axios.post(`${projects}/ircategory/${id}/${regmenuid}/${regsmenuid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        addRCurtype({commit}, {id, regmenuid, formData}){
            //alert(id);
            axios.post(`${projects}/ircurtype/${id}/${regmenuid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        addRegtype({commit}, {id, regmenuid, formData}){
            //alert(id);
            axios.post(`${projects}/iregtype/${id}/${regmenuid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        addRSubmenu({commit}, {id, regmenuid, formData}){
            //alert(id);
            axios.post(`${projects}/iregsmenu/${id}/${regmenuid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        addRMenu({commit}, {id, formData}){
            //alert(id);
            axios.post(`${projects}/iregmenu/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        addImpDate({commit}, {id, formData}){
            //alert(id);
            axios.post(`${projects}/iimpdate/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        addCFPaper({commit}, {id, formData}){
            //alert(id);
            axios.post(`${projects}/icfpaper/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        addQLinks({commit}, {id, formData}){
            //alert(id);
            axios.post(`${projects}/iqlinks/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        addDownload({commit}, {id, formData}){
            //alert(id);
            axios.post(`${projects}/idownload/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        addAContent({commit}, {id, formData}){
            //alert(id);
            axios.post(`${projects}/iacontent/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        addCGallery({commit}, {id, formData}){
            //alert(id);
            axios.post(`${projects}/icgallery/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        addCImages({commit}, {id, gid, formData}){
            //alert(id);
            axios.post(`${projects}/icimages/${id}/${gid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        deleteRCategory({}, {catid, id}){
            axios.delete(`${projects}/drcategory/${catid}`)
                .then(() => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        deleteCRtype({}, {regtypeid, id}){
            axios.delete(`${projects}/dcrtype/${regtypeid}`)
                .then(() => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        deleteRsmenu({}, {regsmenuid, id}){
            axios.delete(`${projects}/drsmenu/${regsmenuid}`)
                .then(() => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        deleteRmenu({}, {regmenuid, id}){
            axios.delete(`${projects}/drmenu/${regmenuid}`)
                .then(() => {
                    this.dispatch('fetchRegdetails', id);
                })
                .catch();
        },
        deleteIdate({}, {idmenuid, id}){
            axios.delete(`${projects}/didate/${idmenuid}`)
                .then(() => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        deleteCFPaper({}, {cfpid, id}){
            axios.delete(`${projects}/dcfpaper/${cfpid}`)
                .then(() => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        deleteQLinks({}, {qlid, id}){
            axios.delete(`${projects}/dqlinks/${qlid}`)
                .then(() => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        deleteDownload({}, {did, id}){
            axios.delete(`${projects}/ddownload/${did}`)
                .then(() => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        deleteAContent({}, {acid, id}){
            axios.delete(`${projects}/dacontent/${acid}`)
                .then(() => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        deleteGallery({}, {gid, id}){
            axios.delete(`${projects}/dgallery/${gid}`)
                .then(() => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        deleteGImage({}, {gid, gname, id}){
            axios.delete(`${projects}/dgimage/${gid}/${gname}`)
                .then(() => {
                    this.dispatch('fetchProjdetails', id);
                })
                .catch();
        },
        insertOcm({commit}, {id, ocmsubid, formData}){
            //alert(id);
            axios.post(`${projects}/iocm/${id}/${ocmsubid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        insertOcmtitle({commit}, {id, formData}){
            axios.post(`${projects}/iocmtitle/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        insertOcmsub({commit}, {id, ocmtid, formData}){
            axios.post(`${projects}/iocmsub/${id}/${ocmtid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        updateOcm({commit}, {id, ocmid, formData}){
            //alert(id);
            axios.put(`${projects}/uocm/${id}/${ocmid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        updateOcmtitle({commit}, {id, ocmtid, formData}){
            axios.put(`${projects}/uocmtitle/${id}/${ocmtid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        updateOcmsub({commit}, {id, ocmsid, formData}){
            axios.put(`${projects}/uocmsub/${id}/${ocmsid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        updateOcmPriority({commit}, {id, ocmid, formData}){
            //alert(ocmid);
            axios.put(`${projects}/pocm/${id}/${ocmid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateOcmImage({commit}, {id, ocmid, formData}){
            //alert(ocmid);
            axios.put(`${projects}/ocmimage/${id}/${ocmid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateOcmsubPriority({commit}, {id, ocmsubid, formData}){

            axios.put(`${projects}/psocm/${id}/${ocmsubid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateOcmtitlePriority({commit}, {id, ocmtid, formData})
        {
            axios.put(`${projects}/ptocm/${id}/${ocmtid}`, formData)
                .then(response => {
                    this.dispatch('fetchOcmdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateRAmount({commit}, {id, regid, formData})
        {
            axios.put(`${projects}/ramount/${id}/${regid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateRCategory({commit}, {id, catid, formData})
        {
            axios.put(`${projects}/rcategory/${id}/${catid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateRegtype({commit}, {id, regtypeid, formData})
        {
            axios.put(`${projects}/regtype/${id}/${regtypeid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateRegsubmenu({commit}, {id, regsmenuid, formData})
        {
            axios.put(`${projects}/regsubmenu/${id}/${regsmenuid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateRMenu({commit}, {id, regmenuid, formData})
        {
            axios.put(`${projects}/regmenu/${id}/${regmenuid}`, formData)
                .then(response => {
                    this.dispatch('fetchRegdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateBCdetail({commit}, {id, formData})
        {
            axios.put(`${projects}/bconfdetails/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //commit('resvalue');
                    //alert(state.response);
                    //alert('hi');
                })
                .catch();
        },
        UpdateCDname({commit}, {id, idmenuid, formData})
        {
            axios.put(`${projects}/idmenuname/${id}/${idmenuid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateCdate({commit}, {id, idateid, formData})
        {
            axios.put(`${projects}/idate/${id}/${idateid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateCDorder({commit}, {id, idateid, formData})
        {
            axios.put(`${projects}/idorder/${id}/${idateid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateCDownorder({commit}, {id, did, formData})
        {
            axios.put(`${projects}/downorder/${id}/${did}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateQLOrder({commit}, {id, qlid, formData})
        {
            axios.put(`${projects}/qlorder/${id}/${qlid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateConfDate({commit}, {id, formData})
        {
            axios.put(`${projects}/confdate/${id}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        UpdateCFPaper({commit}, {id, cpid, formData})
        {
            axios.put(`${projects}/cfpaper/${id}/${cpid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateQLinks({commit}, {id, qlid, formData})
        {
            axios.put(`${projects}/qlinks/${id}/${qlid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateDownload({commit}, {id, did, formData})
        {
            axios.put(`${projects}/download/${id}/${did}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateAContent({commit}, {id, acid, formData})
        {
            axios.put(`${projects}/acontent/${id}/${acid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        updateACPriority({commit}, {id, acid, formData})
        {
            axios.put(`${projects}/acpriority/${id}/${acid}`, formData)
                .then(response => {
                    this.dispatch('fetchProjdetails', id);
                    //alert('hi');
                })
                .catch();
        },
        deleteOcm({}, {ocmId, id}){
            axios.delete(`${projects}/docm/${ocmId}`)
                .then(() => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        deleteOcmtitle({}, {ocmtitleId, id}){
            axios.delete(`${projects}/docmtitle/${ocmtitleId}`)
                .then(() => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        },
        deleteOcmsubtitle({}, {ocmsubId, id}){
            axios.delete(`${projects}/docmsubtitle/${ocmsubId}`)
                .then(() => {
                    this.dispatch('fetchOcmdetails', id);
                })
                .catch();
        }
    }
}