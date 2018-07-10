<template>
    <router-link class="btn btn-danger btn-xs" :disabled='!enabled' :to='to'>Delete</router-link>
</template>

<script>
    export default {
        props: {

            to: {
                type: Object,
                required: true,
            },
            enabled: {
                type: Boolean,
                default: true,
            },
        },
    }
</script>
