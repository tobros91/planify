<template>
<span class="badge badge-light" @click="show()">
    {{ num_unread }}
</span>
</template>

<script>

    export default {

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
            }

        },

        created ()
        {
            this.$store.dispatch('notifications/get')
        },

        methods: {

            show ()
            {
                this.$router.push({ name: 'notifications.list' })
            }

        }

    }

</script>
