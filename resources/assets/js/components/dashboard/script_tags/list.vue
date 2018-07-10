<template>
    <div class="panel-body">
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="created_by" slot-scope="props">
                    {{ props.row.created_name }}
                </template>
                <template slot="updated_by" slot-scope="props">
                    {{ props.row.updated_name }}
                </template>
                <template slot="actions" slot-scope="props">
                    <button class='btn btn-default btn-sm' @click="handleEdit(props.row)"><i class="fa fa-pencil"></i> Edit </button>
                </template>
            </v-client-table>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                columns: ['title', 'created_by', 'updated_by', 'actions'],
                rows: [],
                options: {
                    sortable: ['title', 'created_by', 'updated_by'],
                    filterable: ['title', 'created_by', 'updated_by']
                },
            }
        },
        created() {
            this.getScripts();
            this.$bus.$on('getScripts', this.getScripts);
        },
        methods: {
            getScripts: function () {
                this.$constants.Dashboard_API.get('/scripts')
                .then(response => {
                    this.rows = response.data;
                })
                .catch(error => {
                    swal({
                        text: error.message,
                        type: "error",
                    });
                }); 
            },
            handleEdit(row) {
                this.$router.push('/settings/script/'+ row.id);
            }
        }
    }
</script>