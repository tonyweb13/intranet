<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="nteform.name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Description">
            <div class="asterisk_label">*</div>
            <textarea class="form-control input-sm" v-validate="'required'" name="description" placeholder="Description" v-model="nteform.description" 
            :class="{'input': true, 'is-danger': errors.has('description') }"/>
            <div class="pull-right">
                <i v-show="errors.has('description')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('description')" class="help is-danger">{{ errors.first('description') }}</span>
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        data: function () {
            return {
                laddabtn : '',
                nteform: {
                    name: '',
                    description: ''
                }
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.nteform.name && this.nteform.description;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let nteform = this.nteform;
                        let getAxios = '';


                        getAxios = this.$constants.HR_API.get("/ntelistform/create", {
                            params: {
                                name: nteform.name,
                                description: nteform.description,
                            }
                        });

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.nteform = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                            this.$bus.$emit('updateList');
                        });
                    }
                });
            },
        }
    }
</script>