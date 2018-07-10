<template>
    <!--TODO: Well fix this content header once I figure out how to make page header dynamic-->
    <!--<content-header :header="pageTitle" :list="list" />-->
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="ibox">
                <div class="col-lg-12">
                    <ibox-title-header :header="pageHeader" />
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-10">
                                <form method="POST" action="/process/form/list" accept-charset="UTF-8" class="form-horizontal description_form">
                                    <input type="hidden" name="created_by"/>
                                    <div class="form-group col-lg-3">
                                        <div class="control has-icon has-icon-right">
                                            <vSelect name="user_id" :options="locations" label="text" v-validate="'required'" placeholder="Choose location.." />
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <vSelect name="supervisor_id" :options="supervisors" label="text" v-validate="'required'" placeholder="Choose Supervisor.." />
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <vSelect name="type" :options="form_types" label="text" v-validate="'required'" placeholder="Choose type.." />
                                    </div>
                                    <div class="form-group col-lg-3">
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

    import Months from '../months';
    import SearchButtonIcon from "../buttons/searchButtonIcon";
    import IboxTitleHeader from '../shared/iboxTitleHeader.vue';

    export default {
        name: 'monthlyScore',
        data: function () {
            return {
                title: 'Monthly QA Score Tracker',
                header: 'Monthly QA Score Tracker',
                locations: [],
                supervisors: [],
                //TODO: Create form type table
                form_types: []
            }
        },
        created() {
            this.locationsList();
            this.supervisorsList();
        },
        computed: {
            pageTitle() {
                return this.title
            },
            pageHeader() {
                return this.header
            },
            monthsArray() {
                return Months.items
            }
        },
        methods: {
            locationsList: function() {
                axios.get('/api/qa/user/locations')
                    .then(response => {
                            this.locations = response.data;
                        }
                    );
            },
            supervisorsList: function() {
                axios.get('/api/qa/user/supervisors')
                    .then(response => {
                            this.supervisors = response.data;
                        }
                    );
            },
        },
        components: {IboxTitleHeader, Months, SearchButtonIcon}
    }
</script>