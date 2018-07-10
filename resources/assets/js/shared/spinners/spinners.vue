<template>

    <div class="sk-spinner sk-spinner-cube-grid" v-if="loader === 1">
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
        <div class="sk-cube"></div>
    </div>


    <div class="sk-spinner sk-spinner-double-bounce" v-else-if="loader === 2">
        <div class="sk-double-bounce1"></div>
        <div class="sk-double-bounce2"></div>
    </div>


    <div class="sk-spinner sk-spinner-wave" v-else-if="loader === 3">
        <div class="sk-rect1"></div>
        <div class="sk-rect2"></div>
        <div class="sk-rect3"></div>
        <div class="sk-rect4"></div>
        <div class="sk-rect5"></div>
    </div>

    <div class="sk-spinner sk-spinner-three-bounce" v-else>
        <div class="sk-bounce1"></div>
        <div class="sk-bounce2"></div>
        <div class="sk-bounce3"></div>
    </div>

</template>
<style >
    .sk-spinner {
        display: none;
    }
    .is-loading {
        clear: both;
        position: relative;
        background-color: #ffffff;
        color: inherit;
        padding: 15px 20px 20px 20px;
        border-color: #e7eaec;
        border-image: none;
        border-style: solid solid none;
        border-width: 1px 0;
    }
    .is-loading:after {
        content: '';
        background-color: rgba(255, 255, 255, 0.7);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .is-loading > .sk-spinner {
        display: block;
        position: absolute;
        top: 40%;
        left: 0;
        right: 0;
        z-index: 2000;
    }
</style>

<script>
    'use strict';

    export default {
        props : {
            loader : {
                type: String,
                required: false,
                default : 2,
            },
        },
        computed: {

        },
        watch : {
            view_data : function() {

            }
        },
        updated () {

        },
        mounted() {
            console.log(this.loader);
        }


    }
</script>