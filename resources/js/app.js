
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
        component: require('./components/projects-list'),
        meta: { requiresAuth: true }
    },
    {
        path: '/projects/create',
        name: 'projects.create',
        component: require('./components/projects-create'),
        meta: { requiresAuth: true }
    },
    {
        path: '/projects/:project_id',
        component: require('./components/projects-view'),
        meta: { requiresAuth: true },
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
                path: 'tasks/:task_id',
                name: 'tasks-view',
                component: require('./components/tasks-view')
            },
            {
                path: 'tasks/create',
                name: 'tasks.create',
                component: require('./components/tasks-create')
            },
            {
                path: 'tasks/:task_id/edit',
                name: 'tasks.edit',
                component: require('./components/tasks-edit')
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
        path: '/notifications',
        name: 'notifications.list',
        component: require('./components/notifications-list'),
        meta: { requiresAuth: true }
    },
    {
        path: '/profile/:user_id?',
        name: 'profile',
        component: require('./components/profile')
    },
    {
        path: '/settings',
        name: 'settings',
        component: require('./components/settings'),
        meta: { requiresAuth: true }
    },
]

const router = new VueRouter({
    routes,
    mode: 'history',
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!isAuth) {
            window.location.href = '/login'
        } else {
            next()
        }
    } else {
        next()
    }
})

import store from './store'

const app = new Vue({
    el: '#app',
    router,
    store
});
