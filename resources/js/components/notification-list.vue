<template>
<div class="container">

    <h1>
        Notifications <span v-if="num_unread > 0" class="text-info">{{ num_unread }}</span>
         <div class="btn btn-primary float-right" style="color: #fff;" @click="markAll()" v-if="num_unread > 0">
            Mark all as read
        </div>
    </h1>

    <ul class="list-group mt-3" v-if="!routerLoading">

        <li class="list-group-item" v-for="notification in notifications">
            <component :is="typeToComponent[notification.type]" :key="notification.id" :notification="notification"></component>
        </li>
        <li class="list-group-item" v-if="notifications.length === 0">
            No notifications
        </li>
    </ul>

    <loader height="100" v-if="routerLoading"></loader>

</div>
</template>

<script>

    import invitedToProject from './notifications/invited-to-project'
    import kickedFromProject from './notifications/kicked-from-project'
    import assignedToTask from './notifications/assigned-to-task'
    import kickedFromTask from './notifications/kicked-from-task'
    import commentSubmited from './notifications/comment-submited'
    import loader from './loader'

    export default {

        components: {

            invitedToProject,
            kickedFromProject,
            assignedToTask,
            kickedFromTask,
            commentSubmited,
            loader
        },

        data ()
        {
            return {
                typeToComponent: {
                    'App\\Notifications\\InvitedToProject': 'invited-to-project',
                    'App\\Notifications\\KickedFromProject': 'kicked-from-project',
                    'App\\Notifications\\AssignedToTask': 'assigned-to-task',
                    'App\\Notifications\\KickedFromTask': 'kicked-from-task',
                    'App\\Notifications\\CommentSubmited': 'comment-submited',
                }
            }
        },

        created ()
        {
            this.$store.dispatch('notifications/get')
            .then(() => {
                this.setRouterLoading(false)
            })
        },


        computed: {

            notifications ()
            {
                return this.$store.state.notifications.all
            },

            num_unread ()
            {
                return this.notifications.filter(notification => {
                    return !notification.read_at
                }).length
            },

        },

        methods: {

            mark (notification)
            {
                if (notification.read_at) {
                    return
                }

                axios.put('/data/notifications/'+notification.id+'/markAsRead')
                .then((response) => {
                    console.log('mark notification response')
                    console.log(response.data);
                    this.$store.dispatch('notifications/get')
                })
                .catch((error) => {
                    console.log(error);
                });
            },

            markAll ()
            {
                axios.get('/data/notifications/markAllAsRead')
                .then((response) => {
                    console.log('markAll notification response')
                    console.log(response.data);
                    this.$store.dispatch('notifications/get')
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>
