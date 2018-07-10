<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Corrective Action">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="corrective action" type="text" placeholder="Corrective Action"
                   v-model="corrective.corrective_action" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('corrective action') }" >
            <div class="pull-right">
                <i v-show="errors.has('corrective action')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('corrective action')" class="help is-danger">{{ errors.first('corrective action') }}</span>
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            correctiveProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                corrective: {
                    corrective_action: '',
                },
            };
        },
        created(){
            if(this.correctiveProps.cor_id){
                this.corrective.corrective_action = this.correctiveProps.cor_corrective;
            } else {
                this.corrective.corrective_action = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create(document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.corrective.corrective_action;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let corrective = this.corrective;
                        let getAxios = '';

                        if(this.correctiveProps.cor_id){

                            getAxios = this.$constants.HR_API.get("/correctiveaction/"+this.correctiveProps.cor_id, {
                                params: {
                                    corrective_action: corrective.corrective_action,
                                }
                            });

                        } else {

                            getAxios = this.$constants.HR_API.get("/correctiveaction/create", {
                                params: {
                                    corrective_action: corrective.corrective_action,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.corrective = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                            this.$bus.$emit('updateList');
                        });
                    }
                });
            },
        },
    }
</script>