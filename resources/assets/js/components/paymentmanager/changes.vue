<template>
    <ibox title="List of Changes">
        <add-button @add="addEditRow()" textToAdd="Changes"/>
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
            <add-edit :changeProps="changes" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from './form.vue'

    export default {
        components: { addEdit },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Changes',
                            edit: 'Edit Changes',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'loan_id', 'last_name', 'request_type', 'effective_date', 'confirmed_amount', 'confirmed_date', 'employee_name', 'status', 'payment_type'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        loan_id: 'Loan Id',
                        last_name: 'Last name',
                        request_type: 'Request Type',
                        effective_date: 'Effective Date',
                        confirmed_amount: 'Confirmed Amount',
                        confirmed_date: 'Confirmed Date',
                        employee_name: 'Employee Name',
                        status: 'Status',
                        payment_type : 'Payment Type'
                    },
                    sortable: ['loan_id', 'last_name', 'request_type', 'effective_date', 'confirmed_amount', 'confirmed_date', 'employee_name', 'status', 'payment_type'],
                    filterable: ['loan_id', 'last_name', 'request_type', 'effective_date', 'confirmed_amount', 'confirmed_date', 'employee_name', 'status', 'payment_type']
                },
                headerName: '',
                openModal: false,
                changes: {
                    id: '',
                    loan_id: '',
                    last_name: '',
                    request_type: '',
                    effective_date: '',
                    confirmed_amount: '',
                    confirmed_date: '',
                    employee_name: '',
                    status: '',
                    payment_type: '',
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
                this.$constants.PaymentManager_API.get("/paymentchanges")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.changes.id = props_row.id;
                    this.changes.loan_id = props_row.loan_id;
                    this.changes.last_name = props_row.last_name;
                    this.changes.request_type = props_row.request_type;
                    this.changes.effective_date = props_row.effective_date;
                    this.changes.confirmed_amount = props_row.confirmed_amount;
                    this.changes.confirmed_date = props_row.confirmed_date;
                    this.changes.employee_name = props_row.employee_name;
                    this.changes.status = props_row.status;
                    this.changes.payment_type = props_row.payment_type;
                } else {
                    this.headerName = this.labels.add;
                    this.changes.id = '';
                    this.changes.loan_id = '';
                    this.changes.last_name = '';
                    this.changes.request_type = '';
                    this.changes.effective_date = '';
                    this.changes.confirmed_amount = '';
                    this.changes.confirmed_date = '';
                    this.changes.employee_name = '';
                    this.changes.status = '';
                    this.changes.payment_type = '';
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.loan_id + ' ?',
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
                                props_row.loan_id + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.loan_id + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    };
</script>