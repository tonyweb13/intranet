export default {
    props: ['label', 'value', 'required', 'disabled'],
    methods: {
        onInput: function (event) {
            this.$emit('input', event.target.value);
        },
    },


}