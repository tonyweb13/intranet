<template>
    <div class="col-lg-12 no-padding">
        <div class="ibox">
            <template v-for="(top_driver, index) in top_drivers">
                <div class="ibox-title">
                    <h2 class="text-center">Top Drivers {{ top_driver.type }}</h2>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <template v-for="(data, index) in top_driver.data">
                            <top-drivers-list-data :title="data.category" :descriptions="data.descriptions"/>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
    'use strict';

    import TopDriversListData from "./topDriversListData.vue";

    export default {
        components: {TopDriversListData},
        name: 'topDrivers',
        data() {
            return {

            }
        },
        props: {
            top_drivers: {
                type: Array,
                required: true,
                default: () => []
            }
        }
    }
</script>