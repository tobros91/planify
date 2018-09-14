<template>
<div class="form-group row">

    <label :for="name" class="col-sm-2 col-form-label">{{ label }}</label>
    <div class="col-sm-10">

        <input :type="type" class="form-control" :class="isInvalid" :id="name" :placeholder="label" :value="value" @input="$emit('input', $event.target.value)" v-if="type != 'textarea'">

        <textarea class="form-control" :class="isInvalid" :id="name" :placeholder="label" :value="value" @input="$emit('input', $event.target.value)" v-if="type == 'textarea'"></textarea>

        <div class="invalid-feedback" v-if="error && error[0]">
            {{ error[0] }}
        </div>

    </div>

</div>
</template>

<script>

    export default {

        props: {
            value: {},
            type: {},
            name: {},
            label: {},
            error: {},
        },

        computed: {

            isInvalid ()
            {
                return this.error ? 'is-invalid' : ''
            }

        }
    }

</script>
