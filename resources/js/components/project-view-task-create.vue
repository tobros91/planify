<template>
<div class="container">

    <h4>Create task</h4>

    <div class="card">

        <div class="card-body">

            <input-text
                type="text"
                name="title"
                label="Title"
                v-model="task.title"
                :error="errors.title"
            />

            <input-text
                type="textarea"
                name="description"
                label="Description"
                v-model="task.description"
                :error="errors.description"
            />

            <input-datepicker
                name="starts_at"
                label="Starts at"
                v-model="task.starts_at"
                :error="errors.starts_at"
                :disabled-dates="disabledDatesStartsAt"
            />

            <input-datepicker
                name="ends_at"
                label="Ends at"
                v-model="task.ends_at"
                :error="errors.ends_at"
                :disabled-dates="disabledDatesEndsAt"
            />

            <button type="submit" class="btn btn-primary float-right" @click="store()">Store</button>

        </div>
    </div>
</div>
</template>

<script>

    import datepicker from 'vuejs-datepicker';
    import inputText from './form/input-text'
    import inputDatepicker from './form/input-datepicker'

    export default {

        components: {
            datepicker,
            inputText,
            inputDatepicker
        },

        data ()
        {
            return {
                task: {
                    title: '',
                    description: '',
                    starts_at: '',
                    ends_at: '',
                },
                errors: {},
            }
        },

        computed: {

            disabledDatesStartsAt ()
            {
                if (this.task.ends_at) {
                    return {
                        from: moment(this.task.ends_at).toDate()
                    }
                }
            },

            disabledDatesEndsAt ()
            {
                if (this.task.starts_at) {
                    return {
                        to: moment(this.task.starts_at).toDate()
                    }
                }
            }

        },

        methods: {

            store ()
            {
                axios.post('/data/projects/'+this.$route.params.project_id+'/tasks',
                    this.task
                )
                .then((response) => {
                    console.log(response.data);

                    this.$router.push({ name: 'project-view-task-view', params: { task_id: response.data.id }})
                })
                .catch((error) => {
                    console.log(error.response);

                     if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }

                });
            }

        }

    }

</script>
