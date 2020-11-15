require('./bootstrap');

window.Vue = require('vue');

let axios = require('axios');

Vue.component('questions', require('./components/Questions.vue').default);

const app = new Vue({
    el: '#app',
});