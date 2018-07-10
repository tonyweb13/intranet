<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="activity.name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Class">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Class"
                   v-model="activity.class" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('class') }" >
            <div class="pull-right">
                <i v-show="errors.has('class')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('class')" class="help is-danger">{{ errors.first('class') }}</span>
        </form-group>
        <form-group label="Label Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Label Name"
                   v-model="activity.label_name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('label_name') }" >
            <div class="pull-right">
                <i v-show="errors.has('label_name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('label_name')" class="help is-danger">{{ errors.first('label_name') }}</span>
        </form-group>
        <form-group label="Icon">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Icon"
                   v-model="activity.icon" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('icon') }" >
            <div class="pull-right">
                <i v-show="errors.has('icon')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('icon')" class="help is-danger">{{ errors.first('icon') }}</span>
        </form-group>
        <custom-textarea label="Description:" v-model="activity.description"/>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            activityProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                activity: {
                    name: '',
                    class: '',
                    label_name: '',
                    icon: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.activityProps.id){
                this.activity.name = this.activityProps.name;
                this.activity.class = this.activityProps.class;
                this.activity.label_name = this.activityProps.label_name;
                this.activity.icon = this.activityProps.icon;
                this.activity.description = this.activityProps.description;
            } else {
                this.activity.name = '';
                this.activity.class = '';
                this.activity.label_name = '';
                this.activity.icon = '';
                this.activity.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.activity.name;
                return this.activity.class;
                return this.activity.label_name;
                return this.activity.icon;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let activity = this.activity;
                        let getAxios = '';

                        if(this.activityProps.id){

                            getAxios = this.$constants.TK_API.get("/shiftactivities/"+this.activityProps.id, {
                                params: {
                                    name: activity.name,
                                    class: activity.class,
                                    label_name: activity.label_name,
                                    icon: activity.icon,
                                    description: activity.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.TK_API.get("/shiftactivities/create", {
                                params: {
                                    name: activity.name,
                                    class: activity.class,
                                    label_name: activity.label_name,
                                    icon: activity.icon,
                                    description: activity.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.activity = response.data;
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