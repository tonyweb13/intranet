<template>
    <div class="row wrapper wrapper-content border-bottom page-heading">
        <!--TODO: Well fix this content header once I figure out how to make page header dynamic-->
        <div class="row">
            <template v-for="(item, index) in items">
                <ibox-float :columnClass="iboxColumn" :titleClass="item.class" :title="item.title" :resultTotal="item.value" />
            </template>
        </div>
        <div class="row">
            <div class="ibox">
                <div class="col-lg-12">
                    <ibox-title-header :header="pageHeader" />
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-8">
                                <form method="POST" action="supervisors/process/form/list" accept-charset="UTF-8" class="form-horizontal description_form">
                                    <input type="hidden" name="created_by"/>
                                    <div class="form-group col-lg-4">
                                        <vSelect name="supervisor_id" :options="supervisors" label="text" v-validate="'required'" placeholder="Choose Supervisor.." />
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <search-button-icon />
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <table id="form-table" class="table table-bordered table-striped compact" cellspacing="0" width="100%"></table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    'use strict';

    import axios from 'axios';

    import IboxFloat from "../commons/iboxFloat";
    import SearchButtonIcon from  '../buttons/searchButtonIcon.vue';
    import IboxTitleHeader from '../shared/iboxTitleHeader.vue';

    export default {
        name: 'disputes',
        data: function () {
            return {
                title: 'Dispute Summary',
                header: 'Dispute Summary',
                supervisors: [],
                //TODO: Replace this static data with actual data from disputes table
                items: [
                    {
                        title: 'Disputes',
                        value: '27',
                        class: ''
                    },
                    {
                        title: 'Valid Disputes',
                        value: '5',
                        class: 'text-success'
                    },
                    {
                        title: 'Invalid Disputes',
                        value: '22',
                        class: ''
                    }
                ],
                iboxColumn: 'col-lg-4'
            }
        },
        created() {
            this.supervisorsList();
        },
        computed: {
            pageHeader() {
                return this.header
            },
        },
        methods: {
            supervisorsList: function() {
                axios.get('/api/qa/user/supervisors')
                    .then(response => {
                            this.supervisors = response.data;
                        }
                    );
            },
        },
        components: {IboxTitleHeader, IboxFloat, SearchButtonIcon}
    }
</script>