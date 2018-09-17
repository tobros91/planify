export default [
    {
        path: '/projects',
        name: 'project-list',
        component: require('./components/project-list'),
        meta: { requiresAuth: true }
    },
    {
        path: '/projects/create',
        name: 'project-create',
        component: require('./components/project-create'),
        meta: { requiresAuth: true }
    },
    {
        path: '/projects/:project_id',
        component: require('./components/project-view'),
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                name: 'project-view',
                component: require('./components/project-view-overview')
            },
            {
                path: 'tasks',
                name: 'project-view-task-list',
                component: require('./components/project-view-task-list')
            },
            {
                path: 'tasks/create',
                name: 'project-view-task-create',
                component: require('./components/project-view-task-create')
            },
            {
                path: 'tasks/:task_id',
                name: 'project-view-task-view',
                component: require('./components/project-view-task-view')
            },
            {
                path: 'tasks/:task_id/edit',
                name: 'project-view-task-edit',
                component: require('./components/project-view-task-edit')
            },
            {
                path: 'calendar',
                name: 'project-view-calendar',
                component: require('./components/project-view-calendar')
            },
            {
                path: 'team',
                name: 'project-view-team-list',
                component: require('./components/project-view-team-list')
            },
            {
                path: 'team/invite',
                name: 'project-view-team-invite',
                component: require('./components/project-view-team-invite')
            },
        ]
    },
    {
        path: '/notifications',
        name: 'notification-list',
        component: require('./components/notification-list'),
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
