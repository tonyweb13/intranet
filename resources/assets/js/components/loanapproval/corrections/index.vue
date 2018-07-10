<template>
    <ibox title="List of Corrections">
        <add-button @add="addEditRow()" textToAdd="Corrections"/>
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
            <add-edit :correProps="corr_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from './addEdit.vue'

    export default {
        components: { addEdit },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Correction',
                            edit: 'Edit Correction',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'correction_name', 'corr_parent', 'code', 'description'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        correction_name: 'Correction Name',
                        corr_parent: 'Parent Correction',
                        code: 'Code',
                        description: 'Description',
                    },
                    sortable: ['correction_name', 'corr_parent', 'code', 'description'],
                    filterable: ['correction_name', 'corr_parent', 'code', 'description']
                },
                headerName: '',
                openModal: false,
                corr_data: {
                    id: '',
                    correction_name: '',
                    parent_correction_id: '',
                    code: '',
                    description: '',
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
                this.$constants.LoanApp_API.get("/correction")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.corr_data.id = props_row.id;
                    this.corr_data.correction_name = props_row.correction_name;
                    this.corr_data.parent_correction_id = props_row.parent_correction_id;
                    this.corr_data.code = props_row.code;
                    this.corr_data.description = props_row.description;
                } else {
                    this.headerName = this.labels.add;
                    this.corr_data.id = '';
                    this.corr_data.correction_name = '';
                    this.corr_data.parent_correction_id = '';
                    this.corr_data.code = '';
                    this.corr_data.description = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.correction_name + ' ?',
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
                            this.$constants.LoanApp_API.delete("/correction/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.correction_name + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.correction_name + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    };
</script>