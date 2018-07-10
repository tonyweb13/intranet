<template>
    <div class="ibox">
        <div class="ibox-title"v-for="(survey, index) in surveys">
            <h5>{{ survey.survey_name }}</h5>
        </div>
            
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-2 text-center" v-for="(question, i) in questions">
                    <h2>{{ question.question }}</h2>
                    <img class="img-responsive" :src="question.image" @click="index = i">
                    
                    <form-group v-if="question.survey_type === 4">                                
                        {{ question.votes + ' Vote(s)' }}
                        <br>
                        <button v-bind:class=" question.id == question.voted ? 'btn btn-danger btn-circle btn-lg' : 'btn btn-danger btn-circle btn-lg btn-outline'" @click="castVote(question)" 
                                type="button">
                            <i class="fa fa-heart"></i>
                        </button>
                    </form-group>
                </div>
                <vue-gallery-slideshow :images="images" :index="index" @close="index = null">

                </vue-gallery-slideshow>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .image {
        width: 230px;
        height: 160px;
        background-size: contain;
        cursor: pointer;
        margin: 10px;
        border-radius: 3px;
    }
</style>
<script>
    import VueGallerySlideshow from 'vue-gallery-slideshow'

    export default {
        components: {
            VueGallerySlideshow
        },
        data: function () {
            return {
                surveys: [],
                questions: [],
                
                quest: {
                    question_id: null,
                },
                images: [],
                index:null,
                params: {
                    question_id: null,
                    question_name: null,
                },
                checkCss: false,
                answers: [],
                laddabtn: '',
                form_id: [],
            }
        },
        created() {
            this.fetchSurvey();
            this.fetchQuestion();
        },
        methods: {
            viewImage: function (params) {
                swal({
                    title: 'Sweet!',
                    text: 'Modal with a custom image.',
                    imageUrl: params.image,
                    imageWidth: auto,
                    imageHeight: auto,
                    imageAlt: 'Custom image',
                    animation: true
                })
            },
            castVote: function (params) {
                this.$constants.ACTION_API.post("/vote/cast", {
                        survey_id: params.survey_id,
                        question_id : params.id,
                        name: params.question,
                    })
                    .then(response => {
                        if (response.data.errors) {
                            swal('', response.data.errors, 'error');
                            
                        } else {
                            let param = {
                                newvotes: true
                            };
                            swal('', response.data.success, 'success');
                            this.fetchQuestion();
                        }
                    })
            },
            checkVote: function (params) {
                if (params.id == params.voted) {
                    return  true;
                } else {
                    return false;
                }
            },
            parseString: function (params) {
                var ret = JSON.parse(params);                
                
                return ret.choice;
            },
            fetchSurvey: function () {
                this.$constants.ACTION_API.get("/survey/edit/" + this.$route.params.survey_id)
                    .then(response => {
                        this.surveys = response.data;
                    });
            },
            fetchQuestion: function () {
                this.$constants.ACTION_API.get("/getquestion/" + this.$route.params.survey_id)
                    .then(response => {
                        this.questions = response.data;

                        response.data.forEach(elem => {
                            this.images.push(elem.image);
                            this.params.question_name = elem.question;
                            this.form_id.push({question_id: elem.id});
                        });
                    });
            },
        }
    }
</script>