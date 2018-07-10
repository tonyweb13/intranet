<template>
    <div class="panel-body">
        <v-client-table :data="rows" :columns="columns" :options="options">
        </v-client-table>
    </div>
</template>
<script>

    export default {
        data: function() {
            return {
                columns: ['aba_number', 'reason'],
                rows: [],
                options: {
                    headings: {
                        aba_number: 'ABA Number',
                        reason: 'Reason',
                    },
                    sortable: ['aba_number', 'reason'],
                    filterable: ['aba_number', 'reason']
                },
            }
        },
        created() {
            this.getList();
        },
        methods: {
            getList: function () {
                this.$constants.LoanApp_API.get("/badaba")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
        }
    }
</script>