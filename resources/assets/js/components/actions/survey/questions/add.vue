<template>
    <form @submit.prevent="addQuestion">
        <div class="row">
            <div class="col-lg-6">
                <form-group label="Survey Type">
                    <vSelect name="survey_type"
                            v-model="survey.type"
                            :options="surveyType"
                            label="text" />
                </form-group>

                <form-group label="Image Upload">
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput" style="white-space: nowrap;">
                            <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                            <span class="fileinput-filename" style="white-space: nowrap; width: 120px; overflow: hidden;text-overflow: ellipsis;"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file">
                            <span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                            <input type="hidden"><input type="file" v-on:change="onFileChange" name="image_file">
                        </span>
                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                </form-group>
                <custom-textarea label="Questions/Name" placeholder="Questions" v-model="survey.question"  />
            </div>
            <div class="col-lg-6">
                    <div v-for="(choice, index) in survey.ans">
                        <form-group label="Enter the choices" v-show="textfield">
                            <input v-model="choice.choice" type="text" class="form-control"> 
                        </form-group>
                    </div>
                    <form-group v-show="boole">
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks">
                            <label>
                                True &nbsp;&nbsp;
                                <input type="radio" value="true" checked v-model="survey.bool"  name="true" >
                            </label>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks">
                            <label>
                                False &nbsp;&nbsp;
                                <input type="radio" value="false" checked v-model="survey.bool"  name="false" >
                            </label>
                        </div>
                    </form-group>
                    <form-group v-show="multipleField">
                        <div class="input-group m-b" v-for="(choice, index) in survey.ans">
                            <span class="input-group-addon"><input type="checkbox"> 
                            </span> 
                            <input v-model="choice.choice" type="text" class="form-control"> 
                        </div>
                    </form-group>
            </div>
            <!-- <div class="col-lg-12">
                <button type="button" @click="addLine" class="btn btn-primary pull-right">Add choices</button> 
            </div> -->
        </div>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            quesProps: Object,
        },
        data: function () {
            return {
                survey: {
                    type: '',
                    question: '',
                    image:'',
                    ans: [{
                        choice: null,
                    }],
                    bool: [{
                        choice: null,
                    }]
                },
                boole: false,
                textfield: false,
                multipleField: false,
                surveyType: [
                    // { text: 'Multiple Choices', value: 0 },
                    // { text: 'Multiple Selection', value: 1 },
                    // { text: 'True or False', value: 2 },
                    // { text: 'Fill in the blank', value: 3 },
                    { text: 'Voting Survey', value: 4 },
                ],
                laddabtn: '',
            }
        },
        created(){
            if (this.quesProps.survey_id) {
                this.survey.type = this.quesProps.survey_type;
                this.survey.question = this.quesProps.question;
                //this.survey.ans = questionProps.answers;
            } else {
                this.survey.type = '';
                this.survey.question = '';
                //this.survey.image = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
            $('[type=radio]').prop('checked',true).iCheck({
                    radioClass: 'iradio_square-green',
                },'update');
          
        },
        computed: {
            isComplete () {
                return this.survey.type;
            }
        },
        watch: {
            'survey.type': function (newVal) {
                if (newVal.text === 'True or False') {
                    this.boole = true;
                    this.textfield = false;
                    this.multipleField = false;
                    
                } else if (newVal.text === 'Multiple Selection') {
                    this.multipleField = true;
                    this.boole = false;
                    this.textfield = false;
                    
                } else if (newVal.text === 'Voting Survey') {
                    this.multipleField = false;
                    this.boole = false;
                    this.textfield = false;
                    
                } else {
                    this.boole = false;
                    this.textfield = true;
                    this.multipleField = false;
                }
            }
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.survey.image = e.target.result;
                    this.upload()
                };
                reader.readAsDataURL(file);
                
            },
            upload: function () {
                this.$constants.ACTION_API.post('/upload/question', {image: this.survey.image})
                        .then(response => {
                            if (response.data.errors) {
                                this.laddabtn.stop();
                                swal('','Invalid file!', 'warning');
                            } else {
                                this.survey.image = response.data;
                            }
                        }).catch(error => {
                            this.laddabtn.stop();
                            swal('', 'Please import a valid Image', 'warning');
                        });  
            },
            addLine: function () {
                this.survey.ans.push({choice: null})
            },
            addQuestion: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let survey = this.survey;
                        let getAxios = '';

                        getAxios = this.$constants.ACTION_API.get("/question/create", {
                                params: {
                                            survey_id: this.$route.params.survey_id,
                                            survey_type: survey.type.value,
                                            question: survey.question,
                                            answers: this.bool ? this.bool : survey.ans,
                                            image: survey.image,
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