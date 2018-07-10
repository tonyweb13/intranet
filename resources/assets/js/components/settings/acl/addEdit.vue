<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Rule Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="rule name" type="text" placeholder="Rule Name"
                   v-model="acl.name" v-validate="'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('rule name') }" >
            <div class="pull-right">
                <i v-show="errors.has('rule name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('rule name')" class="help is-danger">{{ errors.first('rule name') }}</span>
        </form-group>
        <form-group label="Rule Parent" v-show="showParent">
            <vSelect name="rule parent"
                     v-model="acl.parent"
                     :options="selectedParent"
                     label="text"
            />
        </form-group>
        <form-group label="Is Enable">
            <div class="asterisk_label">*</div>
            <vSelect name="is enable"
                     v-model="acl.isEnable"
                     :options="selectedIsEnable"
                     label="text"
                     v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('is enable')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('is enable')" class="help is-danger">{{ errors.first('is enable') }}</span>
        </form-group>
        <form-group label="Label">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="label" type="text" placeholder="Label"
                   v-model="acl.label" v-validate="'required|alpha_spaces'" :class="{'input': true, 'is-danger': errors.has('label') }" >
            <div class="pull-right">
                <i v-show="errors.has('label')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('label')" class="help is-danger">{{ errors.first('label') }}</span>
        </form-group>
        <custom-textarea label="Description" placeholder="Description" v-model="acl.description"  />
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            aclProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                acl: {
                    name: '',
                    parent: '',
                    isEnable: '',
                    label: '',
                    description: '',
                },
                selectedParent: [],
                selectedIsEnable: [
                    { text: 'Yes', value: 1 },
                    { text: 'No', value: 0 },
                ],
                showParent:false
            };
        },
        created(){
            this.$constants.Settings_API.get("/acl_rule_parent/dropdown")
                .then(response => {
                     if(Object.keys(response.data).length === 0){
                        this.showParent = false;
                         this.acl.parent = '';
                     } else {
                         this.showParent = true;
                        this.selectedParent = response.data;
                     }
                });

            if(this.aclProps.acl_id){
                this.acl.name = this.aclProps.acl_name;
                this.acl.isEnable = this.aclProps.acl_isEnable;
                this.acl.label = this.aclProps.acl_label;
                this.acl.description = this.aclProps.acl_description;
                if(this.aclProps.acl_parent){
                   this.acl.parent = this.aclProps.acl_parent;
                }
            } else {
                this.acl.name = '';
                this.acl.parent = '';
                this.acl.isEnable = '';
                this.acl.label = '';
                this.acl.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.acl.name && this.acl.isEnable && this.acl.label;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let acl = this.acl;
                        let getAxios = '';

                        if(this.aclProps.acl_id){

                            getAxios = this.$constants.Settings_API.get("/acl/"+this.aclProps.acl_id, {
                                params: {
                                            rule_name: acl.name,
                                            rule_parent_id: acl.parent.value,
                                            is_enable: acl.isEnable.value,
                                            label: acl.label,
                                            description: acl.description
                                        }
                            });

                        } else {

                            getAxios = this.$constants.Settings_API.get("/acl/create", {
                                params: {
                                    rule_name: acl.name,
                                    rule_parent_id: acl.parent.value,
                                    is_enable: acl.isEnable.value,
                                    label: acl.label,
                                    description: acl.description
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.acl = response.data;
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