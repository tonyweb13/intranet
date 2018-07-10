<template>
    <router-link class="btn btn-warning btn-xs" :disabled='!enabled' :to='to'>Edit</router-link>
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
