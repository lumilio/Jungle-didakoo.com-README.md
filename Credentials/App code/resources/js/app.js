import './bootstrap';
import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";
import router from "./router";
import App from "./App.vue";
Vue.use(VueRouter);
const app = new Vue({
    el: '#app',
    store,
    render: h => h(App),
    router
});









