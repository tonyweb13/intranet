<template>
    <div class="col-lg-6 no-padding">
        <div class="ibox">
            <h3 class="text-center">{{ title }}</h3>
            <div class="ibox-content originator-operations" style="max-height: 300px; min-height: 300px;  overflow-y: scroll; padding-bottom: 6px">
                <template v-for="(description, index) in descriptions">
                    <div class="col-lg-10">{{ description.name }}</div>
                    <div class="col-lg-2">{{ description.count }}</div>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
    'use strict';

    export default {
        name: 'TopDriversListData',
        props: {
            title: {
                type: String
            },
            descriptions: {
                type: Array,
                required: true,
                default: () => []
            }
        }
    }
</script>