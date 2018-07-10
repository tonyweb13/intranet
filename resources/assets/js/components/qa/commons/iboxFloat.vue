<template>
    <div :class="columnClass">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5 :class="titleClass"> {{ title }}</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ resultTotal }}</h1>
                <small>Total</small>
            </div>
        </div>
    </div>
</template>
<script>
    'use script';

    export default {
        name: 'iboxFloat',
        props: {
            title: {
                type: String,
                default: ''
            },
            resultTotal: {
                type: String,
                default: ''
            },
            titleClass: {
                type: String,
                default: ''
            },
            columnClass: {
                type: String,
                default: ''
            }
        }
    }
</script>