<template>
    <div class="panel-body">
        <add-button @add="addEditRow()" textToAdd="Question"/>
        <v-client-table :data="rows" :columns="columns" :options="options">
            <template slot="actions" slot-scope="props">
                <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.add }}</button>
                <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.delete }}</button>
            </template>
        </v-client-table>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add :quesProps="questions"  slot="body" />
        </modal>

    </div>
</template>
<script>
    import add from './add.vue'

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
                columns: ['actions', 'question', 'created_by'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        question: 'Question',
                        created_by: 'Created By'
                    },
                    sortable: ['question', 'created_by'],
                    filterable: ['question', 'created_by']
                },
                questions: {
                    survey_id: '',
                    survey_type: '',
                    question: '',
                    answers: '',
                    image: '',
                },
                headerName: '',
                openModal: false,
            }
        },
        created() {
            this.fetchQuestion();
            this.$bus.$on('updateList', this.fetchQuestion);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods: {
            addEditRow: function (props_row) {
                this.openModal = true;
                if (props_row) {
                    this.headerName ="Edit question";
                    this.questions.survey_id = props_row.survey_id;
                    this.questions.survey_type = props_row.survey_type;
                    this.questions.question = props_row.question;
                    this.questions.answers = props_row.answers;
                    this.questions.image = props_row.image;
                } else {
                    this.headerName ="Add question";
                    this.questions.survey_id = '';
                    this.questions.survey_type = '';
                    this.questions.question = '';
                    this.questions.answers = '';
                    this.questions.image = '';
                }
               
            },
            fetchQuestion: function () {
                 this.$constants.ACTION_API.get("/getquestion/" + this.$route.params.survey_id)
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.question + ' ?',
                    text: "Once deleted, you will not be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                })
                    .then((result) => {
                        if (result.value) {
                            this.$constants.Settings_API.delete("/acl/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.fetchQuestion();
                                });
                            swal(
                                'Deleted!',
                                props_row.question + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.question + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    }
</script>