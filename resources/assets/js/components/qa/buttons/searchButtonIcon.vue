<template>
    <div class="input-group-btn">
        <button class="btn btn-info search" type="button" @click="search">
            <span class="glyphicon glyphicon-search"></span>
        </button>
    </div>
</template>
<script>
    'use strict';

    export default {
        name: 'searchButtonIcon',
        props: ['search']
    }
</script>