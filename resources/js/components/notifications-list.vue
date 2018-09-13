<template>
<div class="container">

    <h1>Notifications</h1>

    <ul class="list-group mt-3">

        <li class="list-group-item" v-for="notification in notifications">
            <component :is="typeToComponent[notification.type]" :key="notification.id" :notification="notification"></component>
        </li>
        <li class="list-group-item" v-if="notifications.length === 0">
            No notifications
        </li>
    </ul>
</div>
</template>

<script>

    import invitedToProject from './notifications/invited-to-project'

    export default {

        components: {

            invitedToProject,

        },

        data ()
        {
            return {
                typeToComponent: {
                    'App\\Notifications\\InvitedToProject': 'invited-to-project'
                }
            }
        },

        computed: {

            notifications ()
            {
                return this.$store.state.notifications.all
            }

        },

    }

</script>
