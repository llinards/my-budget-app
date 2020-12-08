require('./bootstrap');

import Vue from 'vue';

Vue.component('budget-app',
    require('./App.vue').default)

const app = new Vue({
    el: '#app'
});
