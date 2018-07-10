<template>
    <ibox title="List of Survey">
        <add-button @add="addSurvey()" textToAdd="Survey"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions" slot-scope="props">
                    <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.add }}</button>
                    <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.delete }}</button>
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">Add Survey</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add slot="body" />
        </modal>
        
    </ibox>
</template>
<script>
    import add from './add.vue'
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    import "element-ui/lib/theme-chalk/index.css";

    export default {
        components: { add },
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Edit',
                            delete: 'Delete',
                        }
                    }
                },

            },
        data: function () {
            return {
                columns: ['actions', 'survey_name', 'created_by', 'questions'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        survey_name: 'Survey name',
                        created_by: 'Created By',
                        questions: 'Number of questions'
                    },
                    sortable: ['survey_name', 'created_by', 'questions'],
                    filterable: ['survey_name', 'created_by', 'questions']
                },
                openModal: false,
            }
        },
        created() {
            this.fetchSurvey();
            this.$bus.$on('updateList', this.fetchSurvey);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods: {
            fetchSurvey: function () {
                this.$constants.ACTION_API.get("/survey")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addSurvey: function () {
                this.openModal = true;
            },
            addEditRow: function (row) {
                this.$router.push('/settings/survey/edit/' + row.id);
            }
        }
    }
</script>