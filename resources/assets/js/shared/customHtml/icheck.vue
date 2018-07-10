<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <label v-for='radio in radios'> 
            <div class="iradio_square-green" :checked='value == radio.value'>
                <input type="radio" @input="onInput" :required="required" v-model="value" :value='radio.value'>
            </div>
            <i></i>
             {{ radio.text }}
        </label>
    </div>
</template>
<script>
    export default {
        props: {
            label: '',
            required: '',
            radios: {
                type: Array,
                required: true
            },
            
        },
        data: function() {
            return {
                value: 0
            }
        },
        methods: {
            onInput: function (event) {
                this.$emit('input', event.target.value)
            }
        }
    }
</script>