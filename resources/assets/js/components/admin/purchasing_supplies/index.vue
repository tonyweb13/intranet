<template>
    <ibox title="List of Purchasing Supplies">
        <add-button @add="addEditRow()" textToAdd="Purchasing Supplies"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions" slot-scope="props">
                                
<!--                 <button slot="edit" slot-scope="props" class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                <button slot="delete" slot-scope="props" class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button> -->

                    <!-- approved -->
                    <button v-if="employee.designation_id == 56 && props.row.assistant_status != 3" class='btn btn-primary btn-xs' data-style="slide-right" @click="approval(3, props.row.id, props.row.control_number, props.row.requested_name)">
                        <i class="fas fa-thumbs-up"></i> {{ labels.approveBtn }}</button>

                    <button v-else-if="employee.designation_id == 33 && props.row.supervisor_status != 3" class='btn btn-primary btn-xs' data-style="slide-right" @click="approval(3, props.row.id, props.row.control_number, props.row.requested_name)">
                        <i class="fas fa-thumbs-up"></i> {{ labels.approveBtn }}</button>

                    <button v-else class='btn btn-primary btn-xs' disabled="disabled">
                        <i class="fas fa-thumbs-up"></i> {{ labels.approveBtn }}</button>  
                    
                    <!-- disapproved -->
                    <button v-if="employee.designation_id == 56 && props.row.assistant_status != 5" class='btn btn-danger btn-xs' data-style="slide-right" @click="approval(5, props.row.id, props.row.control_number, props.row.requested_name)">
                        <i class="fas fa-thumbs-down"></i> {{ labels.disappoveBtn }}</button>  

                    <button v-else-if="employee.designation_id == 33 && props.row.supervisor_status != 5" class='btn btn-danger btn-xs' data-style="slide-right" @click="approval(5, props.row.id, props.row.control_number, props.row.requested_name)">
                        <i class="fas fa-thumbs-down"></i> {{ labels.disappoveBtn }}</button>  

                    <button v-else class='btn btn-danger btn-xs' disabled="disabled" >
                        <i class="fas fa-thumbs-down"></i> {{ labels.disappoveBtn }}</button>  
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields">
                <i>Required Fields ( <span class="required_asterisk">*</span> )</i>
            </small>
            <add-edit :purchasingProps="pur_data" slot="body" />
        </modal>

    </ibox>
</template>
<style scoped>
    .modal-footer{
        display: none;
    }
</style>
<script>
    import addEdit from '../../../components/admin/purchasing_supplies/addEdit.vue'

    export default {
        components: { addEdit },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Purchasing Supplies',
                            edit: 'Edit Purchasing Supplies',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete',
                            approveBtn: 'Approve',
                            disappoveBtn: 'Disapprove'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'control_number', 'dep_name', 'loc_name', 'item_code', 'total_amount', 'requested_name', 'request_received_name', 'supplies_issued_name', 'supplies_received_name', 'assistant_remark', 'approved_name', 'supervisor_remark'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        edit: '',
                        delete: '',
                        dep_name: 'Department',
                        loc_name: 'Location',
                        requested_name: 'Requested By',
                        approved_name: 'Approved By',
                        request_received_name: 'Request Received By',
                        supplies_issued_name: 'Supplies Issued By',
                        supplies_received_name: 'Supplies Received By'
                    },
                    sortable: ['control_number', 'dep_name', 'loc_name', 'item_code'],
                    filterable: ['control_number', 'dep_name', 'loc_name', 'item_code'],
                },
                headerName: '',
                openModal: false,
                pur_data: {
                    control_number: '',
                    dep_name: '',
                    loc_name: '',
                    order_quantity: '',
                    item_code: '',
                    item_description: '',
                    unit: '',
                    amount: '',
                    total_amount: '',
                    issued_quantity: '',
                    issued_date_received: '',
                    pending_order_quantity: '',
                    pending_date_received: '',
                    requested_name: '',
                    approved_name: '',
                    request_received_name: '',
                    supplies_issued_name: '',
                    supplies_received_name: '',
                    pur_id: ''
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
                this.$constants.ADMIN_API.get("/purchasing_supplies")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            approvalUpdate(status, propId){
                this.$constants.ADMIN_API.put("/purchasing_supplies/approval", {
                    request_id: propId,
                    designation: this.employee.designation_id,
                    employee_id : this.employee.id,
                    status : status
                }).then(response => {
                    console.log(response.data);
                    this.$bus.$emit('updateList');
                });
            },
            approval(status, propId, propRequest, propRequestedBy){

                if(status == 3){ //Approved
                    swal({
                        title: 'Are you sure you approve?',   
                        text: 'Control number '+propRequest+ ' and requested by '+propRequestedBy,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                        cancelButtonText: 'Cancel',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-default',
                    }).then((result) => {
                        if (result.value) {
                            this.approvalUpdate(status, propId);
                            swal(
                                'Approved!',
                                'Control Number: ' + propRequest + ' was approved!',
                                "success",
                            );

                        }
                    });

                } else if(status == 5){ //Disapproved

                    swal({
                        title: 'Are you sure you disapprove?',   
                        text: 'Control number '+propRequest+ ' and requested by '+propRequestedBy,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                        cancelButtonText: 'Cancel',
                        confirmButtonClass: 'btn btn-danger',
                        cancelButtonClass: 'btn btn-default',
                    }).then((result) => {
                        if (result.value) {
                            this.approvalUpdate(status, propId);
                            swal(
                                'Disapproved!',
                                'Control Number: ' + propRequest + ' was disapproved!',
                                "success",
                            );

                        }
                    });
                }

            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.pur_data.control_number = props_row.control_number;
                    this.pur_data.dep_name = props_row.dep_name;
                    this.pur_data.loc_name = props_row.loc_name;
                    this.pur_data.order_quantity = props_row.order_quantity;
                    this.pur_data.item_code = props_row.item_code;
                    this.pur_data.item_description = props_row.item_description;
                    this.pur_data.unit = props_row.unit;
                    this.pur_data.amount = props_row.amount;
                    this.pur_data.total_amount = props_row.total_amount;
                    this.pur_data.issued_quantity = props_row.issued_quantity;
                    this.pur_data.issued_date_received = props_row.issued_date_received;
                    this.pur_data.pending_order_quantity = props_row.pending_order_quantity;
                    this.pur_data.pending_date_received = props_row.pending_date_received;
                    this.pur_data.requested_name = props_row.requested_name;
                    this.pur_data.approved_name = props_row.approved_name;
                    this.pur_data.request_received_name = props_row.request_received_name;
                    this.pur_data.supplies_issued_name = props_row.supplies_issued_name;
                    this.pur_data.supplies_received_name = props_row.supplies_received_name;
                    this.pur_data.pur_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.pur_data.control_number            = '';
                    this.pur_data.dep_name                = '';
                    this.pur_data.loc_name                  = '';
                    this.pur_data.order_quantity            = '';
                    this.pur_data.item_code                 = '';
                    this.pur_data.item_description          = '';
                    this.pur_data.unit                      = '';
                    this.pur_data.amount                    = '';
                    this.pur_data.total_amount              = '';
                    this.pur_data.issued_quantity           = '';
                    this.pur_data.issued_date_received      = '';
                    this.pur_data.pending_order_quantity    = '';
                    this.pur_data.pending_date_received     = '';
                    this.pur_data.requested_name              = '';
                    this.pur_data.approved_name               = '';
                    this.pur_data.request_received_name       = '';
                    this.pur_data.supplies_issued_name        = '';
                    this.pur_data.supplies_received_name      = '';
                    this.pur_data.pur_id                    = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.control_number + ' ?',
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
                            this.$constants.ADMIN_API.delete("/purchasing_supplies/"+props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.control_number + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.control_number + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    };
</script>