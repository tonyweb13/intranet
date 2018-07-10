<template>
    <div class="row wrapper wrapper-content border-bottom white-bg page-heading">
        <section class="content-header">
            <div class="col-lg-12">
                <h2>
                    <div class="col-lg-9 no-padding">
                        {{ header }}
                    </div>
                    <div class="col-lg-3">
                        <form :action="url">
                            <div class="col-lg-8 pull-right">
                                <div class="input-group">
                                    <select-input :options="monthsArray"/>
                                    <show-button />
                                </div>
                            </div>
                        </form>
                    </div>
                </h2>
                <breadcrumb :list="listArray"/>
            </div>
        </section>
    </div>
</template>
<script>
    'use strict';

    import months from '../months';
    import breadcrumb from '../Breadcrumb';
    import selectInput from '../inputs/selectInput.vue';
    import showButton from  '../buttons/showButton.vue';

    export default {
        name: 'contentHeader',
        props: {
            header: {
                type: String,
                required: true,
                default: ''
            },
            url: {
                type: String,
                default: ''
            },
            list: {
                type: Array
            },
        },
        data: function() {
            current_month: 0
        },
        created() {
            this.currentRmonth()
        },
        computed: {
            monthsArray() {
                return months.items
            },
            listArray () {
                return this.list
            },
            currentRmonth: function () {
                let d = new Date();
                this.current_month = d.getMonth();
            }
        },
        components: {breadcrumb, selectInput, showButton}
    }
</script>