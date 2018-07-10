<template>
    <ibox title="List of Provisions">
        <add-button @add="addEditRow()" textToAdd="Provision"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="category" slot-scope="props">
                    {{ props.row.category.name }}
                </template>
                <template slot="actions_row" slot-scope="props">
                    <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                    <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add-edit :provisionProps="provision_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../../components/hr/nte/provision/addEdit.vue'

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
                            add: 'Add Provision',
                            edit: 'Edit Provision',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions_row', 'provision', 'category'],
                rows:  [],
                options: {
                    headings: {
                        actions_row: 'Actions',
                    },
                    sortable: ['provision', 'category'],
                    filterable: ['provision', 'category']
                },
                headerName: '',
                openModal: false,
                provision_data: {
                    prov_provision: '',
                    prov_category: '',
                    prov_id: '',
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
                this.$constants.HR_API.get("/provision")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.provision_data.prov_provision = props_row.provision;
                    this.provision_data.prov_category = props_row.category.name;
                    this.provision_data.prov_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.provision_data.prov_provision = '';
                    this.provision_data.prov_category = '';
                    this.provision_data.prov_id = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.provision + ' ?',
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
                            this.$constants.HR_API.delete("/provision/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.provision + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.provision + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    }
</script>