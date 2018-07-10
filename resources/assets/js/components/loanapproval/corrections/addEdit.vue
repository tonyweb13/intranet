<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Correction Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="correction name" type="text" placeholder="Correction Name"
                   v-model="correction.name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Correction name') }" >
            <div class="pull-right">
                <i v-show="errors.has('Correction name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('Correction name')" class="help is-danger">{{ errors.first('Correction name') }}</span>
        </form-group>
        <form-group label="Correction Parent Id" v-show="showParent">
            <vSelect name="correction parent"
                     v-model="correction.parent"
                     :options="selectedParent"
                     label="text"
            />
        </form-group>
        <form-group label="Code">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="code" type="text" placeholder="Code"
                   v-model="correction.code" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('code') }" >
            <div class="pull-right">
                <i v-show="errors.has('code')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('code')" class="help is-danger">{{ errors.first('code') }}</span>
        </form-group>
        <custom-textarea label="Description" placeholder="Description" v-model="correction.description"  />
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            correProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                correction: {
                    name: '',
                    parent: '',
                    code: '',
                    description: '',
                },
                selectedParent: [],
                showParent:false
            };
        },
        created(){
            this.$constants.LoanApp_API.get("/correction_parent/dropdown")
                .then(response => {
                     if(Object.keys(response.data).length === 0){
                        this.showParent = false;
                         this.correction.parent = '';
                     } else {
                         this.showParent = true;
                        this.selectedParent = response.data;
                     }
                });

            if(this.correProps.id){
                this.correction.name = this.correProps.correction_name;
                this.correction.parent = this.correProps.parent_correction_id;
                this.correction.code = this.correProps.code;
                this.correction.description = this.correProps.description;
                if(this.correProps.correction_name){
                   this.correction.parent = this.correProps.correction_name;
                }
            } else {
                this.correction.name = '';
                this.correction.parent = '';
                this.correction.code = '';
                this.correction.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.correction.name && this.correction.code;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let correction = this.correction;
                        let getAxios = '';

                        if(this.correProps.id){

                            getAxios = this.$constants.LoanApp_API.get("/correction/"+this.correProps.id, {
                                params: {
                                            correction_name: correction.name,
                                            parent_correction_id: correction.parent.value,
                                            code: correction.code,
                                            description: correction.description
                                        }
                            });

                        } else {

                            getAxios = this.$constants.LoanApp_API.get("/correction/create", {
                                params: {
                                    correction_name: correction.name,
                                    parent_correction_id: correction.parent.value,
                                    code: correction.code,
                                    description: correction.description
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.correction = response.data;
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