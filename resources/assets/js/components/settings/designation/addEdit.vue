<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="designation.name" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            designationProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                designation: {
                    name: '',
                },
            };
        },
        created(){
            if(this.designationProps.desig_id){
                this.designation.name = this.designationProps.desig_name;
            } else {
                this.designation.name = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.designation.name;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let designation = this.designation;
                        let getAxios = '';

                        if(this.designationProps.desig_id){

                            getAxios = this.$constants.Settings_API.get("/designation/"+this.designationProps.desig_id, {
                                params: {
                                    name: designation.name,
                                }
                            });

                        } else {

                            getAxios = this.$constants.Settings_API.get("/designation/create", {
                                params: {
                                    name: designation.name,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.department = response.data;
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