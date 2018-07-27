import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions';
import getters from './getters';
import mutations from './mutations';

Vue.use(Vuex);

let store = new Vuex.Store({
    state: {
        authenticated: false,
        loading: false,
        user: {
            id: null,
            email: null,
            FirstName: null,
            LastName: null,
            phone: null,
            City: null,
            Street: null,
            houseNumber: null,
            state: null,
            aptNumber: null,
            postalCode: null,
            accountBalance: 0,
            currency: 'USD',
            country: null
        },
        countries: []
    },
    getters,
    mutations,
    actions
});
export default store;