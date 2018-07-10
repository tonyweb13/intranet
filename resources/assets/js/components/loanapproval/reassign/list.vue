<template>
    <div class="panel-body">
        <div>
            <!--<v-client-table :data="rows" :columns="columns" :options="options">-->
            <!--</v-client-table>-->


            <v-server-table url="/api/loanapproval/application/status/1" ref="app_queue" :columns="columns" :options="options">

                <button  slot="" slot-scope="props" class='btn btn-primary btn-xs'>
                    <i class="fas fa-cogs ladda"></i>
                </button>

                <button  slot="view" slot-scope="props" class='btn btn-primary btn-xs' >
                    <i class="fas fa-search ladda"></i> View
                </button>

            </v-server-table>

        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                columns: ['portfolio_id', 'loan_id', 'current_status', 'current_approver', 'reassign_approver'],
                rows: [],
                options: {
                    // perPage : 1,
                    filterByColumn: true,
                    perPageValues: [2, 4, 10, 25, 50, 100],
                    footerHeadings: true,
                    pagination: {chunk: 10},
                    headings: {},
                    templates: {
                        ssn: function (h, row, index) {
                            // console.log(row.ssn.length );
                            return '******' + row.ssn.substr(row.ssn.length - 4);
                        }
                    },
                    query: {
                        created_at: {
                            start: '2010-12-31 00:00:00',
                            end: '2011-12-31 00:00:00'
                        }
                    },
                    params: {
                        portfolios: {}
                    },
                    sortable: ['loan_no', 'portfolio', 'first_name', 'last_name', 'email', 'created_at'],
                    filterable: ['loan_no', 'portfolio', 'first_name', 'last_name', 'email'],
                    groupBy: 'group_date',
                },
            }
        }

    }
</script>