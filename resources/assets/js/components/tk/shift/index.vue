<template>
    <ibox title="List of Shift">
        <add-button @add="addEditRow()" textToAdd="Shift"/>
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
            <add-edit :shiftProps="shift_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../components/tk/shift/addEdit.vue'

    export default {
        components: { addEdit },
        props: 
        {
            labels: {
                type: Object,
                default () {
                    return {
                        add: 'Add Shift',
                        edit: 'Edit Shift',
                        editBtn: 'Edit',
                        deleteBtn: 'Delete'
                    }
                }
            },
        },
        data: function () {
            return {             
                shift_data: {  
                    name: '',
                    description: '',
                    start: '',
                    end: '',
                    is_enable: '',
                    id: ''               
                },
                columns: ['actions', 'name', 'description', 'start','end', 'is_enable'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        name: 'Name',
                        description: 'Description',
                        start: 'Start',
                        end: 'End',
                        is_enable: 'Status',
                    },
                    sortable: ['name', 'description', 'start','end', 'is_enable'],
                    filterable: ['name', 'description', 'start','end', 'is_enable']
                },
                headerName: '',
                openModal: false,
            };
        },
         mounted() {
            this.$emit("update", this.updatePagination);
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
                this.$constants.TK_API.get("/shift")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.shift_data.description = props_row.description;
                    this.shift_data.name = props_row.name;
                    this.shift_data.start = props_row.start;
                    this.shift_data.end = props_row.end;
                    this.shift_data.is_enable = props_row.is_enable;
                    this.shift_data.id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.shift_data.description = '';
                    this.shift_data.name = '';
                    this.shift_data.start = '';
                    this.shift_data.end = '';
                    this.shift_data.is_enable = '';
                    this.shift_data.id = '';
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
                            this.$constants.TK_API.delete("/shift/" + props_row.id)
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