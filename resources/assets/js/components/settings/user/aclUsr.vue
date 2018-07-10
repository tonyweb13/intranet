<template>
	<div class="ibox-content" id="aclrules">
        <!--<code>{{ checkedParent }}</code>-->
        <!--<code>{{ checkedRules }}</code>-->
        <form  v-on:submit.prevent>
            <ul >
                <li v-for="(acl, index) in aclrules">
                    <!--{{acl.rule_name  + ' '+ acl.in_usr_enable}}-->
                    <!--{{aclrules[index]}}-->
                    <div class="switch">
                        <div class="onoffswitch">
                            <input  :name="'rules['+ index + ']'" v-model="aclrules[index].in_usr_enable"  type="checkbox" :checked="acl.in_usr_enable && 'checked' "  class="onoffswitch-checkbox" :id="acl.rule_name + '_' + acl.id ">
                                <label class="onoffswitch-label" :for="acl.rule_name + '_' + acl.id">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    <label class="acllabels">{{acl.label}} ( <span>{{ acl.description }} </span>)</label> 
                    <!--{{acl.childrens}}-->
                    <ul >
                        <li v-for="(acl_child, index_child) in acl.childrens">
                            <!--{{acl.rule_name  + ' '+ acl.in_usr_enable}}-->

                            <span v-if="designation_id != 5 && designation_id != 9 && designation_id != 56 && designation_id != 33
                            && acl.rule_name == 'admin' && ( acl_child.rule_name == 'requestpaymentcreate' || acl_child.rule_name == 'purchasingsuppliescreate' )">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input :name="'rules['+ acl.rule_name + '][' + acl_child.rule_name + ']'" v-model="aclrules[index].childrens[index_child].in_usr_enable"  type="checkbox" :checked="acl_child.in_usr_enable && 'checked'"  class="onoffswitch-checkbox" :id="acl_child.rule_name + '_' + acl_child.id ">
                                    <label class="onoffswitch-label" :for="acl_child.rule_name + '_' + acl_child.id">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <label class="acllabels">{{acl_child.label}} ( <span>{{ acl_child.description }} </span>)</label>
                            </span>

                            <span v-if="acl.rule_name == 'admin' && ( designation_id == 56 || designation_id == 33 ) && ( acl_child.rule_name == 'requestpayment' || acl_child.rule_name == 'purchasingsupplies')">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input :name="'rules['+ acl.rule_name + '][' + acl_child.rule_name + ']'" v-model="aclrules[index].childrens[index_child].in_usr_enable"  type="checkbox" :checked="acl_child.in_usr_enable && 'checked'"  class="onoffswitch-checkbox" :id="acl_child.rule_name + '_' + acl_child.id ">
                                    <label class="onoffswitch-label" :for="acl_child.rule_name + '_' + acl_child.id">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <label class="acllabels">{{acl_child.label}} ( <span>{{ acl_child.description }} </span>)</label>
                            </span>

                            <span v-if="( acl_child.rule_name != 'requestpaymentcreate' && acl_child.rule_name != 'requestpayment') && ( acl_child.rule_name != 'purchasingsuppliescreate' && acl_child.rule_name != 'purchasingsupplies' )">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input :name="'rules['+ acl.rule_name + '][' + acl_child.rule_name + ']'" v-model="aclrules[index].childrens[index_child].in_usr_enable"  type="checkbox" :checked="acl_child.in_usr_enable && 'checked'"  class="onoffswitch-checkbox" :id="acl_child.rule_name + '_' + acl_child.id ">
                                    <label class="onoffswitch-label" :for="acl_child.rule_name + '_' + acl_child.id">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <label class="acllabels">{{acl_child.label}} ( <span>{{ acl_child.description }} </span>)</label>
                            </span>

                                <ul >
                                    <li v-for="(acl_childs, index_childs) in acl_child.childrens">
                                        <!--{{acl.rule_name  + ' '+ acl.in_usr_enable}}-->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input :name="'rules['+ acl.rule_name +'][' + acl_child.rule_name + '][' + acl_childs.rule_name + ']'" v-model="aclrules[index].childrens[index_child].childrens[index_childs].in_usr_enable"  type="checkbox" :checked="acl_childs.in_usr_enable && 'checked'"  class="onoffswitch-checkbox" :id="acl_childs.rule_name + '_' + acl_childs.id ">
                                                <label class="onoffswitch-label" :for="acl_childs.rule_name + '_' + acl_childs.id">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <label class="acllabels">{{acl_childs.label}} ( <span>{{ acl_childs.description }} </span>)</label>
                                    </li>

                                </ul>

                        </li>

                    </ul>


                </li>

            </ul>
            <button class="ladda-button btn btn-primary updateacl"  @click="saveRules" type="submit" data-color="mint" data-style="slide-right">
                Save Rules for this User</button>
        </form>
    </div>
</template>
<style scoped>

#aclrules li {
    list-style: none;
}

#aclrules li .switch {
    display:inline-block;
}

#aclrules li .acllabels {
    margin-left:10px;
    position:relative;
    top:-10px;
    font-size:14px;
}

#aclrules li .acllabels span {
    font-size:10px;
}

#aclrules .onoffswitch-inner:after {
    color:#f40404;
}

#aclrules .updateacl {
    position:fixed;
    bottom:50px;
    right : 100px;
}

</style>
<script>
	export default {
        data () {
            return {
                aclrules: {},
                emp_reference : this.$route.params.employee_id,
                usr_rules : {
                    child_rules : {},
                },
                designation_id: '',
            }
        },
        created(){
            this.$constants.Vps_API.get('/rules/getAclRulesBindToUser/' + this.emp_reference )
                .then(response => {
                    this.aclrules = response.data;
                });

            this.$constants.Settings_API.get("/employee/"+this.$route.params.employee_id+"/edit")
                .then(response => {
                this.designation_id = response.data.designation_id;
            });
        },
        mounted() {
            // this.usrRules = this.aclrules;
            $('.nav-tabs').stickyTabs();

        },
        methods: {
            saveRules(submitEvent) {
                submitEvent.preventDefault();
                let ld = Ladda.create(event.target);
                ld.start();
                this.$constants.Vps_API.post('/rules/saveAclRulesBindToUser/' + this.emp_reference, { rules : this.aclrules})
                    .then(response => {
                        swal({
                            type: 'success',
                            title: 'Permissions Updated',
                            html:  '',
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        ld.stop();
                    })
                    .catch(e => {
                        ld.stop();
                        swal({
                            type: 'error',
                            title: 'Please contact system administrator',
                            html:  '' + e,
                        });
                        // this.errors.push(e);
                    })
            }

        },
        computed: {
            isComplete () {

            },
        }
    }
</script>
