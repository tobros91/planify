
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes = [
    {
        path: '/projects',
        name: 'projects.list',
        component: require('./components/projects-list')
    },
    {
        path: '/projects/create',
        name: 'projects.create',
        component: require('./components/projects-create')
    },
    {
        path: '/projects/:id',
        name: 'projects.view',
        component: require('./components/projects-view')
    },
]

const router = new VueRouter({
    routes,
    mode: 'history',
})

const app = new Vue({
    router,
    el: '#app'
});
