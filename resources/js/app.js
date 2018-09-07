
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
        path: '/projects/:project_id',
        component: require('./components/projects-view'),
        children: [
            {
                path: '',
                name: 'projects.view',
                component: require('./components/projects-view-overview')
            },
            {
                path: 'team',
                name: 'projects.view.team',
                component: require('./components/projects-view-team')
            },
            {
                path: 'calendar',
                name: 'projects.view.calendar',
                component: require('./components/projects-view-calendar')
            },
        ]
    },
    {
        path: '/projects/:project_id/tasks/create',
        name: 'tasks.create',
        component: require('./components/tasks-create')
    },
    {
        path: '/projects/:project_id/tasks/:task_id/edit',
        name: 'tasks.edit',
        component: require('./components/tasks-edit')
    },
]

const router = new VueRouter({
    routes,
    mode: 'history',
})

import store from './store'

const app = new Vue({
    el: '#app',
    router,
    store
});
