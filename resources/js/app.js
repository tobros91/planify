
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('notificationsBadge', require('./components/notifications-badge'));

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
                path: 'tasks',
                name: 'projects.view.tasks',
                component: require('./components/projects-view-tasks')
            },
            {
                path: 'calendar',
                name: 'projects.view.calendar',
                component: require('./components/projects-view-calendar')
            },
            {
                path: 'team',
                name: 'projects.view.team',
                component: require('./components/projects-view-team')
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
    {
        path: '/notifications',
        name: 'notifications.list',
        component: require('./components/notifications-list')
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
