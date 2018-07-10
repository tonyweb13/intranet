<template>
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
       
        <form-group label="Introduction">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="Introduction" type="text" placeholder="Introduction"
                   v-model="survey.introduction" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Introduction') }" >
            <div class="pull-right">
                <i v-show="errors.has('Introduction')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('Introduction')" class="help is-danger">{{ errors.first('Introduction') }}</span>
        </form-group>

        <form-group label="Conclusion">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="Conclusion" type="text" placeholder="Conclusion"
                   v-model="survey.conclusion" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Conclusion') }" >
            <div class="pull-right">
                <i v-show="errors.has('Conclusion')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('Conclusion')" class="help is-danger">{{ errors.first('Conclusion') }}</span>
        </form-group>
        
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        data: function (){
            return {
                laddabtn : '',
                survey: {
                    survey_name: '',
                    introduction : '',
                    conclusion: ''
                }
            }
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
            eventUpdate: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let survey = this.survey;
                        let getAxios = '';

                        getAxios = this.$constants.ACTION_API.get("/survey/create", {
                                params: {
                                    survey_name: survey.survey_name,
                                    introduction: survey.introduction,
                                    conclusion: survey.conclusion,
                                }
                            });

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.survey = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                            this.$bus.$emit('updateList');
                        });
                    }

                });
            }
        }
    }
</script>