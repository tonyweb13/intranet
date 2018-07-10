<template>
    <div class="ibox-title">
        <h5 class="col-lg-4">
            {{ header }}
        </h5>
        <div class="col-lg-2 pull-right" style="margin-top: -7px">
            <div class="col-lg-8 no-padding">
                <div class="input-group" style="width: 100%">
                    <select-input :options="monthsArray" :my_selected_month="my_selected_month" />
                </div>
            </div>
            <div class="col-lg-4 pull-right"><h2>{{full_year}}</h2></div>
        </div>
    </div>
</template>
<script>
    'use strict';
    import Months from '../months';
    import SelectInput from "../inputs/selectInput";
    import ShowButton from "../buttons/showButton";

    export default {
        components: {
            ShowButton,
            SelectInput},
        name: 'iboxTiltleHeader',
        props: {
            header: {
                type: String,
                default: ''
            }
        },

        data() {
            return {
                full_year: '',
                my_selected_month: ''
            };
        },
        created() {
            this.getFullYear();
        },
        computed: {
            monthsArray() {
                return Months.items
            },
        },
        methods: {
            getFullYear() {
                const current_date = new Date();
                this.full_year = current_date.getFullYear();
            },
        }
    }
</script>