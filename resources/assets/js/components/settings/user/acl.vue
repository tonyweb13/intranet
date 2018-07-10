<template>
	<div class="ibox-content">
        <!--<code>{{ checkedParent }}</code>-->
        <!--<code>{{ checkedRules }}</code>-->
        <form @submit.prevent="saveRules">
            <ul class="fa-ul">
                <li v-if="acl.rule_name" v-for="(acl, index) in aclrules" class="col-lg-12">
                    <div>
                        <!--<i class="fa-li fa fa-check-square col-lg-1"></i>-->
                        <div class="switch col-lg-1">
                            <div class="onoffswitch">

                                <!-- if ON -->
                                <input v-if="acl.parent_count == 1" type="checkbox" checked="" disabled="" class="onoffswitch-checkbox" :id="'switch_parent'+index">

                                <!-- else OFF -->
                                <input v-else
                                type="checkbox" checked class="onoffswitch-checkbox" :value="acl.rule_name"
                                v-model="checkedParent" :id="'switch_parent'+index"
                                @click="showChildRow(acl.id, checkedParent, showChild=true, acl.rule_name)">

                                <label class="onoffswitch-label" :for="'switch_parent'+index">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <h3 class="col-lg-10">{{ acl.label }}</h3>
                    </div>
                    <ul class="fa-ul" >
                        <li v-if="showChild || children.child_count == 1" v-for="(children, index) in aclChild" class="col-lg-12" >
                            <i class="fa-li fa fa-check-circle"></i>
                            <div class="switch col-lg-1">
                                <div class="onoffswitch">

                                    <!-- if ON -->
                                    <input type="checkbox" v-if="children.child_count == 1" checked="" class="onoffswitch-checkbox" :id="'switch_sub'+index">

                                    <!-- else OFF -->
                                    <input v-else
                                    type="checkbox" checked class="onoffswitch-checkbox"
                                    :value="children.rule_name" v-model="checkedRules" :id="'switch_sub'+index">


                                    <label class="onoffswitch-label" :for="'switch_sub'+index">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <label class="switch_label col-lg-4">{{ children.rule_name }}</label>
                        </li>
                    </ul>
                </li>
            </ul>
            <button class="ladda-button btn btn-primary " type="submit" :disabled="!isComplete" data-color="mint" data-style="slide-right">
                       Save Rules for this User</button>
        </form>
    </div>
</template>
<style scoped>

</style>
<script>
	export default {
        data: function () {
            return {
                laddabtn : '',
                rules: {},
                aclrules: {},
                aclChild: {},
                switchRule: false,
                showChild: false,
                checkedRules: [],
                checkedParent: [],
                parent: 0
            };
        },
        created(){

            this.$constants.Vps_API.get("/rules/"+this.$route.params.employee_id+"/edit")
                .then(response => {

                this.rules = response.data;

            });
  
            this.$constants.Vps_API.get("/rules/getRuleParent/"+this.$route.params.employee_id)
                .then(response => {
                this.aclrules = response.data;
            }); 

            this.$constants.Vps_API.get("/rules/getRuleChild/"+this.$route.params.employee_id)
                .then(response => {

                this.aclChild = response.data;

            })
        },
        mounted() {
            this.laddabtn = Ladda.create(document.querySelector('.ladda-button'));
        },
        methods: {
            saveRules(){               
                this.laddabtn.start();

                let getAxios = '';

                let parentArray = this.checkedParent
                let childArray = this.checkedRules
                parentArray.push('child_rules');
                parentArray.push(childArray);
                
                console.log("before parentArray==")
                console.log(parentArray)

                var objectMap = this.arrayToObj(parentArray,function (item) {
                                           return {key:item,value:item};
                                        });
            },
            showChildRow (getChildId, checkedParent, showChild, rule_name) {

                if(Object.keys(checkedParent).length == 0){

                    this.$constants.Vps_API.get("/rules/findChild/"+getChildId)
                    .then(response => {

                            this.aclChild = response.data;
                            console.log("showChildRow this.aclChild==")
                            console.log(this.aclChild);
                    });

                } else {
                    this.showChild = false;
                }

            },
            arrayToObj (array, fn) {
                var obj = {};
                var len = array.length;
                for (var i = 0; i < len; i++) {
                    var item = fn(array[i], i, array);
                    obj[item.key] = item.value;
                }
                return obj;
            }
        },
        computed: {
            isComplete () {
                return Object.keys(this.checkedParent).length || Object.keys(this.checkedRules).length
            },
        }
    }
</script>
