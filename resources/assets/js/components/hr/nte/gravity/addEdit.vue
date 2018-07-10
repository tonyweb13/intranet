<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Fields"
                   v-model="gravity.fields" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Gravity">
            <div class="asterisk_label">*</div>
            <vSelect name="gravity"
                v-model="gravity.gravity"
                :options="selectedGravity"
                label="text"
                v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('gravity')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('gravity')" class="help is-danger">{{ errors.first('gravity') }}</span>
        </form-group>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="gravity.description" />
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            gravityProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                gravity: {
                    fields: '',
                    gravity: '',
                    description: '',
                },
                selectedGravity:[],
            };
        },
        created(){
            this.eventGravity();

            if(this.gravityProps.grav_id){
                this.gravity.fields = this.gravityProps.grav_fields;
                this.gravity.gravity = this.gravityProps.grav_gravity;
                this.gravity.description = this.gravityProps.grav_desc;
            } else {
                this.gravity.fields = '';
                this.gravity.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.gravity.fields && this.gravity.gravity;
            }
        },
        methods: {
            eventGravity(){
                this.$constants.HR_API.get("/dropdown/gravity")
                    .then(response => {
                        this.selectedGravity = response.data;
                    });
            },
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let gravity = this.gravity;
                        let getAxios = '';

                        if(this.gravityProps.grav_id){

                            getAxios = this.$constants.HR_API.get("/gravity/"+this.gravityProps.grav_id, {
                                params: {
                                    fields: gravity.fields,
                                    gravity_id: gravity.gravity.value,
                                    description: gravity.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.HR_API.get("/gravity/create", {
                                params: {
                                    fields: gravity.fields,
                                    gravity_id: gravity.gravity.value,
                                    description: gravity.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.gravity = response.data;
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