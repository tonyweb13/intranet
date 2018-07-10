<template>
    <ibox title="List of Survey">
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions" slot-scope="props">
                    <button class='btn btn-primary btn-xs' @click="viewSurvey(props.row)"><i class="fa fa-pencil"></i> View</button>
                </template>
            </v-client-table>
        </div>
    </ibox>
</template>
<script>
    export default {
        data: function () {
            return {
                columns: ['actions', 'survey_name', 'introduction', 'conclusion', 'status'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        survey_name: 'Survey name',
                        introduction: 'Introduction',
                        conclusion: 'Conclusion',
                        status: 'Status'
                    },
                    sortable: ['survey_name', 'introduction', 'conclusion', 'status'],
                    filterable: ['survey_name', 'introduction', 'conclusion', 'status']
                },
                openModal: false,
            }
        },
        created() {
            this.fetchSurvey();
        },
        methods: {
            fetchSurvey: function () {
                this.$constants.ACTION_API.get("/survey")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            viewSurvey: function (row) {
                this.$router.push('/script/survey/exam/' + row.id);
            }
        }
    }
</script>