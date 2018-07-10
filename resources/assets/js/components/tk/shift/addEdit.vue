<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="shift.name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Start">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="start" type="text" placeholder="Start"
                   v-model="shift.start" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('start') }" >
            <div class="pull-right">
                <i v-show="errors.has('start')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('start')" class="help is-danger">{{ errors.first('start') }}</span>
        </form-group>
        <form-group label="End">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="end" type="text" placeholder="End"
                   v-model="shift.end" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('end') }" >
            <div class="pull-right">
                <i v-show="errors.has('end')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('end')" class="help is-danger">{{ errors.first('end') }}</span>
        </form-group>
        <form-group label="Status">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="status" type="text" placeholder="Status"
                   v-model="shift.status" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('status') }" >
            <div class="pull-right">
                <i v-show="errors.has('status')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('status')" class="help is-danger">{{ errors.first('status') }}</span>
        </form-group>
        <custom-textarea label="Description:" v-model="shift.description"/>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            shiftProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                shift: {
                    name: '',
                    start: '',
                    end: '',
                    status: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.shiftProps.id){
                this.shift.name = this.shiftProps.name;
                this.shift.start = this.shiftProps.start;
                this.shift.end = this.shiftProps.end;
                this.shift.status = this.shiftProps.is_enable;
                this.shift.description = this.shiftProps.description;
            } else {
                this.shift.name = '';
                this.shift.start = '';
                this.shift.end = '';
                this.shift.status = '';
                this.shift.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.shift.name;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let shift = this.shift;
                        let getAxios = '';

                        if(this.shiftProps.id){

                            getAxios = this.$constants.TK_API.get("/shift/"+this.shiftProps.id, {
                                params: {
                                    name: shift.name,
                                    start: shift.start,
                                    end: shift.end,
                                    is_enable: shift.status,
                                    description: shift.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.TK_API.get("/shift/create", {
                                params: {
                                    name: shift.name,
                                    start: shift.start,
                                    end: shift.end,
                                    is_enable: shift.status,
                                    description: shift.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.shift = response.data;
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