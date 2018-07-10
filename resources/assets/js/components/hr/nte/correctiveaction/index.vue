<template>
    <ibox title="List of Corrective Actions">
        <add-button @add="addEditRow()" textToAdd="Corrective Action"/>
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
            <add-edit :correctiveProps="corrective_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../../components/hr/nte/correctiveaction/addEdit.vue'

    export default {
        components: {
            addEdit
        },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Corrective Action',
                            edit: 'Edit Corrective Action',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'corrective_action'],
                rows:  [],
                options: {
                    sortable: ['corrective_action'],
                    filterable: ['corrective_action']
                },
                headerName: '',
                openModal: false,
                corrective_data: {
                    cor_corrective: '',
                },
            }
        },
        mounted() {
            this.$emit("update", this.updatePagination);
        },
        created(){
            this.getList();
            this.$bus.$on('updateList', this.getList);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods:{
            getList: function() {
                this.$constants.HR_API.get("/correctiveaction")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.corrective_data.cor_corrective = props_row.corrective_action;
                    this.corrective_data.cor_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.corrective_data.cor_corrective = '';
                    this.corrective_data.cor_id = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.corrective_action + ' ?',
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
                            this.$constants.HR_API.delete("/correctiveaction/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.corrective_action + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.corrective_action + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    }
</script>