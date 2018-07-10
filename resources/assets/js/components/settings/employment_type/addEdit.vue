<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="employmenttype.name" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="employmenttype.description" />
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            employmentTypeProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                employmenttype: {
                    name: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.employmentTypeProps.employmenttype_id){
                this.employmenttype.name = this.employmentTypeProps.employmenttype_name;
                this.employmenttype.description = this.employmentTypeProps.employmenttype_description;
            } else {
                this.employmenttype.name = '';
                this.employmenttype.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.employmenttype.name;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let employmenttype = this.employmenttype;
                        let getAxios = '';

                        if(this.employmentTypeProps.employmenttype_id){

                            getAxios = this.$constants.Settings_API.get("/employment/"+this.employmentTypeProps.employmenttype_id, {
                                params: {
                                    name: employmenttype.name,
                                    description: employmenttype.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.Settings_API.get("/employment/create", {
                                params: {
                                    name: employmenttype.name,
                                    description: employmenttype.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.employmenttype = response.data;
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