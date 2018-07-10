<template>
    <div class="panel-body">
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="status" slot-scope="props" style="width:5%;">
                    <button style="cursor:pointer;" id="" lsdt="27234" loanid="" class="btntagdone ladda-button btn-xs btn btn-outline btn-warning" 
                        data-style="expand-left" type="submit">
                        <i class="fa fa-cog"></i>&nbsp;&nbsp;<strong>Undone</strong>
                    </button>
                </template>
            </v-client-table>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                columns: ['status','portfolio', 'loan_id','submitted_by','adjusted_by','created_at'],
                rows: [],
                options: {
                    groupBy:[
                        'created_at'
                    ],
                    headings: {     
                        portfolio: 'Portfolio ID',
                        loan_id: 'Loan ID',
                        created_at: 'Date Time',
                        status: 'Status'
                    },
                    sortable: ['portfolio', 'loan_id','submitted_by','adjusted_by'],
                    filterable: ['portfolio', 'loan_id','submitted_by','adjusted_by']
                },
            }
        },
        created() {
            this.getAdj();
            this.$bus.$on('getAdjFee', this.getAdj);
        },
        methods: {
            getAdj: function () {
                this.$constants.LoanApp_API.get('/adjustmentfinancefee')
                .then(response => {
                    this.rows = response.data;
                })
                .catch(error => {
                    swal({
                        text: error.message,
                        type: "error",
                    });
                }); 
            }
        }
    }
</script>