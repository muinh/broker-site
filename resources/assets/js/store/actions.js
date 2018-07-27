import _ from 'lodash'
import Vue from 'vue'
import router from "../router"


export default {
    errorReceived(context, error) {
        let errorMessage = _.get(error, 'response.data.error.message', _.get(error, 'response.data.message'));
        if (errorMessage) {
            Vue.toasted.error(errorMessage);
        }
        if (error.response.status === 401) {
            context.dispatch("logout").then(() => router.push('/login'));
        }
    },
    logout(context) {
        context.commit("setAuthenticated", false);
        localStorage.removeItem("_options");
    },
    checkAuth(context) {
        context.commit('loadingOn');
        axios.get('/api/trader').then((response) => {
            if (response.data.hasOwnProperty('FirstName') && response.data.FirstName) {
                context.commit('setAuthenticated', true);
                context.commit('setUser', response.data);
            } else {
                context.commit('setAuthenticated', false);
            }
            context.dispatch('switchLinks');
            context.commit('loadingOff');
        }).catch(() => {
            context.commit('setAuthenticated', false);
            context.dispatch('switchLinks');
            context.commit('loadingOff');
        });
    },
    getCountries(context) {
        axios.get('/api/countries').then((response) => {
            context.commit('setCountries', response.data);
        }).catch(() => {});
    },
    switchLinks(context) {
        if (context.state.authenticated) {
            $('.menu-item.open-account').addClass('d-none');
            $('.menu-item.my-account').removeClass('d-none');
            $('.notLoggedIn').addClass('d-none');
            $('.loggedIn').removeClass('d-none');
            if (['/open-account', '/forgot-password'].indexOf(router.currentRoute.path) !== -1) {
                router.push('/my-account');
            }
        } else {
            if (['/my-account', '/upload-docs'].indexOf(router.currentRoute.path) !== -1) {
                router.push('/');
            }
            $('.menu-item.open-account').removeClass('d-none');
            $('.menu-item.my-account').addClass('d-none');
            $('.notLoggedIn').removeClass('d-none');
            $('.loggedIn').addClass('d-none');
        }
    }
}