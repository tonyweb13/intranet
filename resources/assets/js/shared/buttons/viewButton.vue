<template>
    <router-link class="btn btn-primary btn-xs" :disabled='!enabled' :to='to'>View</router-link>
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
