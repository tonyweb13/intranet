<template>
    <ibox title="List of Portfolio">
        <add-button @add="addEditRow()" textToAdd="Portfolio"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <button slot="edit" slot-scope="props" class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                <button slot="delete" slot-scope="props" class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add-edit :portfolioProps="portfolio_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../components/settings/portfolio/addEdit.vue'

    export default {
        components: { addEdit },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Portfolio',
                            edit: 'Edit Portfolio',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['edit', 'delete', 'name', 'description'],
                rows: [],
                options: {
                    headings: {
                        edit: '',
                        delete: '',
                        name: 'Name',
                        description: 'Description'
                    },
                    sortable: ['name', 'description'],
                    filterable: ['name', 'description']
                },
                headerName: '',
                openModal: false,
                portfolio_data: {
                    portfolio_description: '',
                    portfolio_name: '',
                    portfolio_id: ''
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
                this.$constants.Settings_API.get("/portfolio")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.portfolio_data.portfolio_description = props_row.description;
                    this.portfolio_data.portfolio_name = props_row.name;
                    this.portfolio_data.portfolio_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.portfolio_data.portfolio_description = '';
                    this.portfolio_data.portfolio_name = '';
                    this.portfolio_data.portfolio_id = '';
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
                            this.$constants.Settings_API.delete("/portfolio/" + props_row.id)
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