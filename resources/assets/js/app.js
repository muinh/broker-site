import router from './router'
import store from './store'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import ScheduleCallForm from './components/common/ScheduleCallForm'
import RegisterForm from './components/common/RegisterForm'
import TradingAssets from './components/common/TradingAssets'
import ForgotPassword from './components/common/ForgotPassword'
import ResetPassword from './components/common/ResetPassword'
import MyAccount from './components/common/MyAccount'
import UploadDocs from './components/common/UploadDocs'
import VueSwal from 'vue-swal'
import 'babel-polyfill'
import Toastr from 'vue-toastr';

Vue.component('schedule-call-form', ScheduleCallForm);
Vue.component('register-form', RegisterForm);
Vue.component('trading-assets', TradingAssets);
Vue.component('forgot-password', ForgotPassword);
Vue.component('reset-password', ResetPassword);
Vue.component('my-account', MyAccount);
Vue.component('upload-docs', UploadDocs);
Vue.use(BootstrapVue);
Vue.use(VueSwal);
Vue.use(Toastr);

require('./bootstrap');
window.Vue = require('vue');

const Root = {
    template: '<router-view></router-view>'
};

const app = new Vue({
    components: {Root},
    template: '<Root/>',
    el: '#app',
    router,
    store
});
