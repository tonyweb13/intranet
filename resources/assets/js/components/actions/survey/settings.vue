<template>
    <div class="panel-body">
        <form @submit.prevent="eventUpdate">
            <form-group label="Survey Name">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="Survey name" type="text" placeholder="Survey Name"
                    v-model="survey.survey_name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Survey name') }" >
                <div class="pull-right">
                    <i v-show="errors.has('Survey name')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('Survey name')" class="help is-danger">{{ errors.first('Survey name') }}</span>
            </form-group>

            <custom-textarea label="Introduction" placeholder="Introduction" v-model="survey.introduction"  />

            <custom-textarea label="Conclusion" placeholder="Conclusion" v-model="survey.conclusion"  />
            <save-button :disabled='!isComplete' />
        </form>
    </div>
</template>
<script>
    export default {
        data:function () {
            return {
                survey: {
                    survey_name: '',
                    introduction: '',
                    conclusion: ''
                },
                laddabtn: ''
            }
        },
        created (){
            this.getSurvey();
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.survey.survey_name && this.survey.introduction && this.survey.conclusion;
            }
        },
        methods: {
            getSurvey: function () {
                this.$constants.ACTION_API.get('/survey/edit/' + this.$route.params.survey_id)
                .then(response => {
                    this.survey.survey_name = response.data[0].survey_name;
                    this.survey.introduction = response.data[0].introduction;
                    this.survey.conclusion = response.data[0].conclusion;
                });
            },
            eventUpdate: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let survey = this.survey;
                        let getAxios = '';

                        getAxios = this.$constants.ACTION_API.get("/survey/" + this.$route.params.survey_id, {
                                params: {
                                            survey_name: survey.survey_name,
                                            introduction: survey.introduction,
                                            conclusion: survey.conclusion,
                                        }
                            });

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.survey = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                        });
                    }
                });
            }
        }
    }
</script>