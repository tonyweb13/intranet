<template>
    <ibox title="List of Gravity of Offenses">
        <add-button @add="addEditRow()" textToAdd="Gravity"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="gravity" slot-scope="props">
                    <div style="width: 90px;">{{ props.row.gravity.gravity }}</div>
                </template>
                <template slot="actions_row" slot-scope="props">
                    <div style="width: 120px;">
                        <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                        <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                    </div>
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add-edit :gravityProps="gravity_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../../components/hr/nte/gravity/addEdit.vue'

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
                            add: 'Add Gravity',
                            edit: 'Edit Gravity',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions_row', 'fields','gravity', 'description'],
                rows:  [],
                options: {
                    headings: {
                        actions_row: 'Actions',
                    },
                    sortable: ['fields','gravity'],
                    filterable: ['fields','gravity']
                },
                headerName: '',
                openModal: false,
                gravity_data: {
                    grav_fields: '',
                    grav_desc: '',
                    grav_gravity: '',
                    grav_id: '',
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
                this.$constants.HR_API.get("/gravity")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.gravity_data.grav_fields = props_row.fields;
                    this.gravity_data.grav_desc = props_row.description;
                    this.gravity_data.grav_gravity = props_row.gravity.gravity;
                    this.gravity_data.grav_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.gravity_data.grav_fields = '';
                    this.gravity_data.grav_desc = '';
                    this.gravity_data.grav_gravity = '';
                    this.gravity_data.grav_id = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.fields + ' ?',
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
                            this.$constants.HR_API.delete("/gravity/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.fields + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.fields + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    }
</script>