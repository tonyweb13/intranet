<template>
    <div class="panel-body">
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="priority" slot-scope="props">
                    <button type="button" class="btn btn-danger btn-xs btn-block" v-if="props.row.priority == 2">High</button>
                    <button type="button" class="btn btn-warning btn-xs btn-block" v-if="props.row.priority == 1">Medium</button>
                    <button type="button" class="btn btn-info btn-xs btn-block" v-if="props.row.priority == 0">Low</button>
                </template>
                <template slot="issue" slot-scope="props">
                    <div v-html="props.row.issue ">
                    </div>
                </template>
            </v-client-table>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                columns: ['department_to', 'date_from', 'date_to', 'description', 'priority','issue'],
                rows: [],
                options: {
                    headings: {                        
                        department_to: 'Department to',
                        date_from: 'Date from',
                        date_to: 'Date to',
                        description: 'Description',
                        priority: 'Priority',
                        issue: 'Issue',
                    },
                    sortable: ['department_to', 'date_from', 'date_to', 'description', 'priority','issue'],
                    filterable: ['department_to', 'date_from', 'date_to', 'description', 'priority','issue']
                },
            }
        },
        created() {
            this.getTickets();
            this.$bus.$on('getTickets', this.getTickets);
        },
        methods: {
            getTickets: function () {
                this.$constants.TICKET_API.get('/ticket')
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