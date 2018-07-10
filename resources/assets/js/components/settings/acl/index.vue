<template>
    <ibox title="List of ACL Rules">
        <add-button @add="addEditRow()" textToAdd="User Rules"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions" slot-scope="props">
                    <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                    <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add-edit :aclProps="acl_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../components/settings/acl/addEdit.vue'

    export default {
        components: { addEdit },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add User Rules',
                            edit: 'Edit User Rules',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'rule_name', 'rule_parent', 'is_enable', 'label', 'description'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        rule_name: 'Rule Name',
                        rule_parent: 'Rule Parent',
                        is_enable: 'Is Enable',
                    },
                    sortable: ['rule_name', 'rule_parent', 'is_enable', 'label'],
                    filterable: ['rule_name', 'rule_parent', 'is_enable', 'label']
                },
                headerName: '',
                openModal: false,
                acl_data: {
                    acl_id: '',
                    acl_name: '',
                    acl_parent: '',
                    acl_parent_id: '',
                    acl_isEnable: '',
                    acl_label: '',
                    acl_description: '',
                },
            };
        },
        created() {
            this.getList();
            this.$bus.$on('updateList', this.getList);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods: {
            getList: function () {
                this.$constants.Settings_API.get("/acl")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.acl_data.acl_id = props_row.id;
                    this.acl_data.acl_name = props_row.rule_name;
                    this.acl_data.acl_parent = props_row.rule_parent;
                    this.acl_data.acl_parent_id = props_row.rule_parent_id;
                    this.acl_data.acl_isEnable = props_row.is_enable;
                    this.acl_data.acl_label = props_row.label;
                    this.acl_data.acl_description = props_row.description;
                } else {
                    this.headerName = this.labels.add;
                    this.acl_data.acl_id = '';
                    this.acl_data.acl_name = '';
                    this.acl_data.acl_parent = '';
                    this.acl_data.acl_parent_id = '';
                    this.acl_data.acl_isEnable = '';
                    this.acl_data.acl_label = '';
                    this.acl_data.acl_description = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.rule_name + ' ?',
                    text: "Once deleted, you will not be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                })
                    .then((result) => {
                        if (result.value) {
                            this.$constants.Settings_API.delete("/acl/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.rule_name + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.rule_name + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    };
</script>