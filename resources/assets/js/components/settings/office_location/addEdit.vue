<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="officelocation.name" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="officelocation.description" />
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            officelocationProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                officelocation: {
                    name: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.officelocationProps.office_id){
                this.officelocation.name = this.officelocationProps.office_name;
                this.officelocation.description = this.officelocationProps.office_description;
            } else {
                this.officelocation.name = '';
                this.officelocation.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.officelocation.name;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let officelocation = this.officelocation;
                        let getAxios = '';

                        if(this.officelocationProps.office_id){

                            getAxios = this.$constants.Settings_API.get("/officelocation/"+this.officelocationProps.office_id, {
                                params: {
                                    name: officelocation.name,
                                    description: officelocation.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.Settings_API.get("/officelocation/create", {
                                params: {
                                    name: officelocation.name,
                                    description: officelocation.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.officelocation = response.data;
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