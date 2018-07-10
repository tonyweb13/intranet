<template>
    <router-link class="btn btn-default" :to='to'>Back</router-link>
</template>

<script>
    export default {
        props: {
            to: {
                type: Object,
                required: true,
            },
        },
    }
</script>
