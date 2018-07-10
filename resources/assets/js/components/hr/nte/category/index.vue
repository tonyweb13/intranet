<template>
    <ibox title="List of NTE Categories">
        <add-button @add="addEditRow()" textToAdd="Category"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions_row" slot-scope="props">
                    <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                    <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add-edit :categoryProps="category_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../../components/hr/nte/category/addEdit.vue'

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
                            add: 'Add Category',
                            edit: 'Edit Category',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions_row', 'name', 'description'],
                rows:  [],
                options: {
                    headings: {
                        actions_row: 'Actions',
                    },
                    sortable: ['name'],
                    filterable: ['name']
                },
                headerName: '',
                openModal: false,
                category_data: {
                    cat_name: '',
                    cat_desc: '',
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
                this.$constants.HR_API.get("/nte/category")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.category_data.cat_name = props_row.name;
                    this.category_data.cat_desc = props_row.description;
                    this.category_data.cat_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.category_data.cat_name = '';
                    this.category_data.cat_desc = '';
                    this.category_data.cat_id = '';
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
                            this.$constants.HR_API.delete("/nte/category/" + props_row.id)
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
    }
</script>