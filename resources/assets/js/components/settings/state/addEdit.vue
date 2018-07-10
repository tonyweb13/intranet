<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="state.name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Code">
        <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="code" type="text" placeholder="Code"
                   v-model="state.code" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('code') }" >
            <div class="pull-right">
                <i v-show="errors.has('code')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('code')" class="help is-danger">{{ errors.first('code') }}</span>
        </form-group>
        <form-group label="Rate">
            <input class="form-control input-sm" name="rate" type="number" step="any" placeholder="Rate"
                   v-model="state.rate" v-validate="'required|decimal'" :class="{'input': true, 'is-danger': errors.has('rate') }" >
            <div class="pull-right">
                <i v-show="errors.has('rate')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('rate')" class="help is-danger">{{ errors.first('rate') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="state.description" />
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            stateProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                state: {
                    name: '',
                    code: '',
                    rate: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.stateProps.id){
                this.state.name = this.stateProps.name;
                this.state.code = this.stateProps.code;
                this.state.rate = this.stateProps.rate;
                this.state.description = this.stateProps.description;
            } else {
                this.state.name = '';
                this.state.code = '';
                this.state.rate = '';
                this.state.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.state.name &&
                       this.state.code;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let state = this.state;
                        let getAxios = '';

                        if(this.stateProps.id){

                            getAxios = this.$constants.LoanApp_API.get("/states/"+this.stateProps.id, {
                                params: {
                                    name: state.name,
                                    code: state.code,
                                    rate: state.rate,
                                    description: state.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.LoanApp_API.get("/states/create", {
                                params: {
                                    name: state.name,
                                    code: state.code,
                                    rate: state.rate,
                                    description: state.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.state = response.data;
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