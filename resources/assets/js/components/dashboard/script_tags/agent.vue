<template>
    <div>
        <div v-for="row in rows" class="m-sm">
            <div class="ibox-title">
                <h5> {{ row.title }} </h5>
            </div>
            <div class="ibox-content">
                <div v-html="row.scripts"></div>
            </div>
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
                    sortable: ['title'],
                    filterable: ['title']
                },
            }
        },
        created() {
            this.getScripts();
        },
        methods: {
            getScripts: function () {
                this.$constants.Dashboard_API.get('/script/user')
                .then(response => {
                    this.rows = response.data;
                    console.log("this.row==");
                    console.log(this.rows);
                })
                .catch(error => {
                    swal({
                        text: error.message,
                        type: "error",
                    });
                }); 
            },
            handleEdit(row) {
                this.$router.push('/script/agent/view/'+ row.id);
            }
        }
    }
</script>