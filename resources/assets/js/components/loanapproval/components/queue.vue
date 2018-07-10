<template>
    <div class="col-lg-12">
        <br/>
        <v-client-table :data="rows" :columns="columns" :options="options">
            <button slot="edit" slot-scope="props" class='btn btn-primary btn-xs' @click="editRow(props.row)"><i class="fa fa-pencil"></i> Edit</button>
        </v-client-table>

        <modal v-if="editModal" @close="editModal = false">
                <h3 slot="header">Edit Loan Application</h3>
               <edit-application :loanApplicationProps="loan_data" slot="body">
               </edit-application>
        </modal>
    </div>
</template>
<script>
    import editApplication from '../../../components/loanapproval/components/edit.vue'

    export default {
        components: { editApplication },
        props: {
            tabId: Number,
        },
        data: function () {
            return {
                editModal: false,
                columns: ['edit','id','loan_no', 'portfolio', 'first_name','last_name','email','ssn','state','request_code','ending_balance','new_or_returning','voe','created_at'],
                rows:  [],
                options: {
                    headings: {
                        edit: 'Action',
                        id: "ID",
                        loan_no: 'Loan ID',
                        portfolio: 'Portfolio',
                        first_name: 'First Name',
                        last_name: 'Last Name',
                        email: 'Email Address',
                        ssn: 'SSN',
                        state: 'State',
                        request_code: 'Request Code',
                        ending_balance: 'Ending Balance',
                        new_or_returning: 'Transaction Type',
                        voe: 'VOE',
                        created_at: 'Created at'
                    },
                    sortable: ['id','loan_no', 'portfolio', 'first_name','last_name','email','ssn','state','request_code','ending_balance','new_or_returning','voe','created_at'],
                    filterable: ['id','loan_no', 'portfolio', 'first_name','last_name','email','ssn','state','request_code','ending_balance','new_or_returning','voe','created_at']
                },
                loan_data: {
                    loan_no: '',
                    portfolio: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    ssn: '',
                    state: '',
                    request_code: '',
                    ending_balance: '',
                    new_or_returning: '',
                    voe: '',
                    id: ''
                },
            }
        },
        created () {
            this.getLoanApplication();
        },
        methods: {
            editRow: function(props_row) {
                this.editModal = true;
                this.loan_data.loan_no = props_row.loan_no;
                this.loan_data.portfolio = props_row.portfolio;
                this.loan_data.first_name = props_row.first_name;
                this.loan_data.last_name = props_row.last_name;
                this.loan_data.email = props_row.email;
                this.loan_data.ssn = props_row.ssn;
                this.loan_data.state = props_row.state;
                this.loan_data.request_code = props_row.request_code;
                this.loan_data.ending_balance = props_row.ending_balance;
                this.loan_data.new_or_returning = props_row.new_or_returning;
                this.loan_data.voe = props_row.voe;
                this.loan_data.id = props_row.id;
            },
            getLoanApplication () {
                this.$constants.LoanApp_API.get("/application/status/" + this.tabId)
                    .then(response => {
                        this.rows = response.data;
                    });
            },
        }
    }
</script>