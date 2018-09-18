<template>
<div class="row">
    <div class="col">
        <div class="row mt-3">
            <div class="col-1">
                <img class="img-fluid avatar" :src="notification.data.user.image_url">
            </div>
            <div class="col">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <b>{{ notification.data.user.name }}</b> commented on a task you are assigned to
                        </h5>

                        <h5 class="card-subtitle text-muted">"{{ notification.data.comment.body }}"</h5>
                    </div>
                </div>
            </div>
        </div>

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
