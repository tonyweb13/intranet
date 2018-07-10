<template>
    <router-link :to="{path : route_link}">
        <i :class="icon"></i>{{label}}
    </router-link>
</template>
<script>
    'use strict';

    export default {
        props : {
            childs_menu : {
                type: Array,
                required : false,
            },
            route_link : {
                type: String,
                required : true,
            },
            icon : {
                type: String,
                required: true,
            },
            label : {
                type: String,
                required: true,
            },
        },
    }
</script>