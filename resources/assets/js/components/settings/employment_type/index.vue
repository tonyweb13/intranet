<template>
    <ibox title="List of Employment Type">
        <add-button @add="addEditRow()" textToAdd="Employment Type"/>
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
            <add-edit :employmentTypeProps="employmenttype_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../components/settings/employment_type/addEdit.vue'

    export default {
        components: { addEdit },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Employment Type',
                            edit: 'Edit Employment Type',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'name', 'Description'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        name: 'Name',
                        Description: 'Description'
                    },
                    sortable: ['name', 'Description'],
                    filterable: ['name', 'Description']
                },
                headerName: '',
                openModal: false,
                employmenttype_data: {
                    employmenttype_description: '',
                    employmenttype_name: '',
                    employmenttype_id: ''
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
                this.$constants.Settings_API.get("/employment")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.employmenttype_data.employmenttype_description = props_row.Description;
                    this.employmenttype_data.employmenttype_name = props_row.name;
                    this.employmenttype_data.employmenttype_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.employmenttype_data.employmenttype_description = '';
                    this.employmenttype_data.employmenttype_name = '';
                    this.employmenttype_data.employmenttype_id = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.name + ' ?',
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
                            this.$constants.Settings_API.delete("/employment/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.name + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.name + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    };
</script>