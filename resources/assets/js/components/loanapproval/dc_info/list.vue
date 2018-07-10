<template>
    <div class="panel-body">
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="portfolio" slot-scope="props">
                        {{ props.row.portfolio.name }}
                </template>
                <template slot="card_name" slot-scope="props">
                        ***************
                </template>
                <template slot="card_number" slot-scope="props">
                        ***************
                </template>
                <template slot="card_expiration_date" slot-scope="props">
                        ***************
                </template>
                <template slot="card_cvv_code" slot-scope="props">
                        ***************
                </template>
            </v-client-table>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                columns: ['loan_id', 'portfolio', 'card_name', 'card_number', 'card_expiration_date','card_cvv_code'],
                rows: [],
                options: {
                    headings: {
                        card_name: 'Card Name',
                        card_number: 'Card Number',
                        card_expiration_date: 'Expiration Date',
                        card_cvv_code: 'CVV Code',
                    },
                    sortable: ['loan_id', 'portfolio', 'card_name', 'number', 'expiration_date','cvv_code'],
                    filterable: ['loan_id', 'portfolio', 'card_name', 'number', 'expiration_date','cvv_code']
                },
            }
        },
        created() {
            this.getDcInfo();
            this.$bus.$on('getDcInfo', this.getDcInfo);
        },
        methods: {
            getDcInfo: function () {
                this.$constants.LoanApp_API.get('/dcinfo')
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