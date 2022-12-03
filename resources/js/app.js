import Vue from "vue"
require('./bootstrap');

window.Vue = require('vue').default;

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import axios from "axios";
import VueAxios from 'vue-axios'


axios.defaults.baseURL = process.env.API_URL;

Vue.use(VueAxios, axios);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.component('test', require('./components/test.vue').default);
axios.interceptors.request.use(
    config => {
        config.headers['Authorization'] = `Bearer ${localStorage.getItem('access_token')}`;
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

import router from "./router";

const app = new Vue({
    el: '#app',
    router,
    // mounted () {
    //     let audio = new Audio('http://127.0.0.1:8000/about'); // path to file
    //     audio.play();
    // }
});
