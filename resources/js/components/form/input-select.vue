<template>
<div class="form-group row">

    <label :for="name" class="col-sm-2 col-form-label">{{ label }}</label>
    <div class="col-sm-10">
        <select class="form-control" :class="isInvalid" :id="name" :value="value" @input="$emit('input', $event.target.value)">
            <option :value="option.value" v-for="option in options">{{ option.text }}</option>
        </select>
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
            options: {},
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
