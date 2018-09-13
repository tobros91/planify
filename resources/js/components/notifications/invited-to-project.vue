<template>
<div class="row">
    <div class="col">
        <h3>Invited to project {{ notification.data.project.title }} by user {{ notification.data.project.user_id }}</h3>
    </div>
</div>
</template>

<script>

    export default {

        props: {

            notification: {
                required: true
            }

        },

        data ()
        {
            return {

            }
        },

        methods: {



        }

    }

</script>
