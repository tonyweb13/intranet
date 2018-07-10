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
                            <div class="col-lg-8">
                                <form accept-charset="UTF-8" class="form-horizontal description_form">
                                    <input type="hidden" name="created_by"/>
                                    <div class="form-group col-lg-4">
                                        <div class="control has-icon has-icon-right">
                                            <vSelect
                                                    v-model="employee_id"
                                                    :options="active_users"
                                                    label="text"
                                                    v-validate="'required'"
                                                    placeholder="Search an agent.." />
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <vSelect
                                                v-model="type"
                                                :options="form_types"
                                                label="text"
                                                v-validate="'required'"
                                                placeholder="Choose type.." />
                                    </div>
                                    <div class="form-group col-lg-1">
                                        <search-button-icon :search="search" />
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <create-audit-button v-if="is_create_new_form" :createAudit="createAudit" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <v-client-table :data="rows" :columns="columns" :options="options">
                                    <template slot="actions" slot-scope="props">
                                        <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                                        <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                                    </template>
                                </v-client-table>
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

    import IboxTitleHeader from '../shared/iboxTitleHeader.vue';
    import SearchButtonIcon from  '../buttons/searchButtonIcon.vue';
    import SelectInput from "../inputs/selectInput";
    import CreateAuditButton from "../buttons/createAuditButton";

    export default {
        name: 'formList',
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Create New Form',
                            edit: 'Edit Form',
                            editBtn: 'View',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        watch: {
            employee_id() {
                this.is_create_new_form = false;
            }
        },
        data: function () {
            return {
                title: 'Form List',
                header: 'Search Agent QA Form',
                active_users: [],
                employee_id: '',
                type: '',
                form_types: [],
                is_create_new_form: false,
                columns: ['id', 'employee_no', 'name', 'supervisor', 'location', 'score', 'compliance', 'created_by',
                    'type', 'created_at', 'audit_count', 'audit_status', 'actions'],
                rows: [],
                options: {
                    headings: {
                        id: 'Form ID',
                        employee_no: 'Employee ID',
                        name: 'Name',
                        supervisor: 'Supervisor',
                        location: 'Location',
                        score: 'Score',
                        compliance: 'Compliance',
                        created_by: 'Created By',
                        type: 'Type',
                        created_at: 'Date Created',
                        audit_count: 'Audit #s',
                        audit_status: 'Audit Status',
                        actions: 'Actions'
                    },
                    sortable: ['id', 'employee_no', 'name', 'supervisor', 'location', 'score', 'compliance',
                        'created_by', 'type', 'created_at', 'audit_count', 'audit_status'],
                    filterable: ['id', 'employee_no', 'name', 'supervisor', 'location', 'score', 'compliance',
                        'created_by', 'type', 'created_at', 'audit_count', 'audit_status']
                },
            }
        },
        created() {
            this.activeUsers();
            this.getALLFomrs();
            this.getFormTypes();
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
            activeUsers: function() {
                this.$constants.QA_API.get('/user/active')
                    .then(response => {
                            this.active_users = response.data;
                        }
                    );
            },
            getALLFomrs: function () {
                this.$constants.QA_API.get('/form/all')
                    .then(response => {
                            this.rows = response.data;
                        }
                    );
            },
            getFormTypes: function() {
                this.$constants.QA_API.get('/form/type')
                    .then(response => {
                            this.form_types = response.data;
                        }
                    );
            },
            search: function () {
                this.$constants.QA_API.post('/form/search', {
                    employee_id: (this.employee_id) ? this.employee_id.value : '',
                    type: (this.type) ? this.type.value : ''
                }).then(response => {
                        this.rows = response.data;
                        if (!this.rows.length) {
                            //if no form found for the selected agent show "Create Audit Form"
                            this.is_create_new_form = true;
                        } else {
                            this.is_create_new_form = false;
                        }
                        console.log(this.rows);
                    }
                );
            },
            createAudit: function () {
                const that = this;
                //set is_create_new_form to false hide the 'Create Audit Form' button to avoid clicking the button again
                this.is_create_new_form = false;
                swal({
                    title: '',
                    text: 'Creating form please wait...',
                    allowOutsideClick: false,
                    onOpen: function () {
                        swal.showLoading()
                    }
                });
                setTimeout(function() {
                    that.$constants.QA_API.post('/form/audit/create', {
                        employee_id: (that.employee_id) ? that.employee_id.value : '',
                    })
                        .then(response => {
                            that.rows = response.data;
                            swal.close();
                            swal({
                                title: '',
                                text: 'You have successfully added new QA Form!',
                                type: 'success'
                            });
                        }, function (response) {
                            console.log(response.data);
                        });
                }, 100);
            }
        },
        components: {
            CreateAuditButton,
            IboxTitleHeader, SearchButtonIcon
        }
    }
</script>