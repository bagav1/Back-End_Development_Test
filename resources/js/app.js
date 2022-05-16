require('./bootstrap');

window.Vue = require('vue').default;

Vue.prototype.$http = axios;
import commons from './Commons.js';
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.mixin(commons);


Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);
Vue.component('register-component', require('./components/RegisterComponent.vue').default);

const app = new Vue({
    el: '#app',
});
