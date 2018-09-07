<template>
<div class="card">
    <div class="card-header">
        Create task
    </div>

    <div class="card-body">
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" placeholder="Title" v-model="task.title">
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="description" placeholder="Description" v-model="task.description"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Starts at</label>
            <div class="col-sm-10">
                <datepicker v-model="task.starts_at" :disabledDates="disabledDatesStartsAt" format="yyyy-MM-dd" :bootstrap-styling="true"></datepicker>
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Ends at</label>
            <div class="col-sm-10">
                <datepicker v-model="task.ends_at" :disabledDates="disabledDatesEndsAt" format="yyyy-MM-dd" :bootstrap-styling="true"></datepicker>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" @click="store()">Store</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>

    import datepicker from 'vuejs-datepicker';

    export default {

        components: {
            datepicker
        },

        data ()
        {
            return {
                task: {
                    title: '',
                    description: '',
                    starts_at: '',
                    ends_at: '',
                }
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
                axios.post('/data/projects/'+this.$route.params.id+'/tasks',
                    this.task
                )
                .then((response) => {
                    console.log(response);

                    this.$router.push({ name: 'projects.view', params: { id: this.$route.params.id }})
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>
