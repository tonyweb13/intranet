<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="costcenter.name" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="costcenter.description" />
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            costcenterProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                costcenter: {
                    name: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.costcenterProps.cost_id){
                this.costcenter.name = this.costcenterProps.cost_name;
                this.costcenter.description = this.costcenterProps.cost_description;
            } else {
                this.costcenter.name = '';
                this.costcenter.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.costcenter.name;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let costcenter = this.costcenter;
                        let getAxios = '';

                        if(this.costcenterProps.cost_id){

                            getAxios = this.$constants.Settings_API.get("/costcenter/"+this.costcenterProps.cost_id, {
                                params: {
                                    name: costcenter.name,
                                    description: costcenter.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.Settings_API.get("/costcenter/create", {
                                params: {
                                    name: costcenter.name,
                                    description: costcenter.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.costcenter = response.data;
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