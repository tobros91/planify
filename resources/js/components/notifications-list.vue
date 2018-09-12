<template>
<div class="container">

    <h1>Notifications</h1>

    <ul class="list-group mt-3">
        <li class="list-group-item" v-for="notification in notifications">
            <div class="row">
                <div class="col">
                    <h3>Invited to project {{ notification.data.project.title }} by user {{ notification.data.project.user_id }}</h3>
                </div>
            </div>
        </li>
    </ul>
</div>
</template>

<script>

    export default {

        computed: {

            notifications ()
            {
                return this.$store.state.notifications.all
            }

        },

    }

</script>
