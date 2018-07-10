<template>
    <ibox title="List of Shift Activities">
        <add-button @add="addEditRow()" textToAdd="Shift Activities"/>
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
            <add-edit :activityProps="activity_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../components/tk/shift_activities/addEdit.vue'

    export default {
        components: { addEdit },
        props: 
        {
            labels: {
                type: Object,
                default () {
                    return {
                        add: 'Add Shift Activities',
                        edit: 'Edit Shift Activities',
                        editBtn: 'Edit',
                        deleteBtn: 'Delete'
                    }
                }
            },
        },
        data: function () {
            return {             
                activity_data: {  
                    name: '',
                    class: '',
                    label_name: '',
                    icon: '',
                    description: '',
                    id: ''               
                },
                columns: ['actions', 'name', 'class', 'label_name','icon', 'description'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        name: 'Name',
                        class: 'Class',
                        label_name: 'Label Name',
                        icon: 'Icon',
                        description: 'Description'
                    },
                    sortable: ['name', 'class', 'label_name','icon', 'description'],
                    filterable: ['name', 'class', 'label_name','icon', 'description']
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
                this.$constants.TK_API.get("/shiftactivities")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
           addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.activity_data.description = props_row.description;
                    this.activity_data.name = props_row.name;
                    this.activity_data.class = props_row.class;
                    this.activity_data.label_name = props_row.label_name;
                    this.activity_data.icon = props_row.icon;
                    this.activity_data.id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.activity_data.description = '';
                    this.activity_data.name = '';
                    this.activity_data.class = '';
                    this.activity_data.label_name = '';
                    this.activity_data.icon = '';
                    this.activity_data.id = '';
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
                            this.$constants.TK_API.delete("/shiftactivities/" + props_row.id)
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