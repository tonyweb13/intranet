<template>
    <ibox :title="title">
        <add-button @add="addEditRow()" textToAdd="Request Payment"/>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions" slot-scope="props">

<!--                     <button slot="edit" slot-scope="props" class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa   fa-pencil"></i> {{ labels.editBtn }}</button> -->
<!--                     <button slot="delete" slot-scope="props" class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button> -->

                        <!-- approved -->
                        <button v-if="employee.designation_id == 56 && props.row.assistant_status != 3" class='btn btn-primary btn-xs' data-style="slide-right" @click="approval(3, props.row.id, props.row.request_number, props.row.requested_name)">
                            <i class="fas fa-thumbs-up"></i> {{ labels.approveBtn }}</button>

                        <button v-else-if="employee.designation_id == 33 && props.row.supervisor_status != 3" class='btn btn-primary btn-xs' data-style="slide-right" @click="approval(3, props.row.id, props.row.request_number, props.row.requested_name)">
                            <i class="fas fa-thumbs-up"></i> {{ labels.approveBtn }}</button>

                        <button v-else class='btn btn-primary btn-xs' disabled="disabled">
                            <i class="fas fa-thumbs-up"></i> {{ labels.approveBtn }}</button>  
                        
                        <!-- disapproved -->
                        <button v-if="employee.designation_id == 56 && props.row.assistant_status != 5" class='btn btn-danger btn-xs' data-style="slide-right" @click="approval(5, props.row.id, props.row.request_number, props.row.requested_name)">
                            <i class="fas fa-thumbs-down"></i> {{ labels.disappoveBtn }}</button>  

                        <button v-else-if="employee.designation_id == 33 && props.row.supervisor_status != 5" class='btn btn-danger btn-xs' data-style="slide-right" @click="approval(5, props.row.id, props.row.request_number, props.row.requested_name)">
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
            <add-edit :paymentProps="payment_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../components/admin/request_payment/addEdit.vue'

    export default {
        components: { addEdit },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Request Payment',
                            edit: 'Edit Request Payment',
                            approveBtn: 'Approve',
                            disappoveBtn: 'Disapprove'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'request_number', 'dep_name', 'supplier', 'payee', 'amount', 'due_date', 'description', 'requested_name', 'noted_name', 'assistant_remark', 'approved_name', 'supervisor_remark' ],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        dep_name: 'Department',
                        requested_name: 'Requested By',
                        noted_name: 'Noted By',
                        approved_name: 'Approved By',
                    },
                    sortable: ['request_number', 'dep_name', 'supplier'],
                    filterable: ['request_number', 'dep_name', 'supplier'],
                },
                headerName: '',
                openModal: false,
                payment_data: {
                    request_number: '',
                    dep_name: '',
                    supplier: '',
                    payee: '',
                    amount: '',
                    due_date: '',
                    description: '',
                    requested_name: '',
                    noted_name: '',
                    approved_name: '',
                    payment_id: ''
                },
                title: ''
            };
        },
        created() {

            this.title = "List of Request Payment";
            this.getList(); 

            this.$bus.$on('updateList', this.getList);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods: {
            getList: function () {
                this.$constants.ADMIN_API.get("/request_payment")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            approvalUpdate(status, propId){
                this.$constants.ADMIN_API.put("/request_payment/approval", {
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
                        text: 'Request number '+propRequest+ ' and requested by '+propRequestedBy,
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
                                'Request Number: ' + propRequest + ' was approved!',
                                "success",
                            );

                        }
                    });

                } else if(status == 5){ //Disapproved

                    swal({
                        title: 'Are you sure you disapprove?',   
                        text: 'Request number '+propRequest+ ' and requested by '+propRequestedBy,
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
                                'Request Number: ' + propRequest + ' was disapproved!',
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
                    this.payment_data.request_number = props_row.request_number;
                    this.payment_data.dep_name = props_row.dep_name;
                    this.payment_data.supplier = props_row.supplier;
                    this.payment_data.payee = props_row.payee;
                    this.payment_data.amount = props_row.amount;
                    this.payment_data.due_date = props_row.due_date;
                    this.payment_data.description =  props_row.description;
                    this.payment_data.requested_name = props_row.requested_name;
                    this.payment_data.noted_name = props_row.noted_name;
                    this.payment_data.approved_name = props_row.approved_name;
                    this.payment_data.payment_id = props_row.id;
                } else {
                    this.headerName = this.labels.add;
                    this.payment_data.request_number =  '';
                    this.payment_data.dep_name =  '';
                    this.payment_data.supplier =  '';
                    this.payment_data.payee =  '';
                    this.payment_data.amount =  '';
                    this.payment_data.due_date =  '';
                    this.payment_data.description =  '';
                    this.payment_data.requested_name =  '';
                    this.payment_data.noted_name =  '';
                    this.payment_data.approved_name =  '';
                    this.payment_data.payment_id =  '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.request_number + ' ?',
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
                            this.$constants.ADMIN_API.delete("/request_payment/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.request_number + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.request_number + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    };
</script>