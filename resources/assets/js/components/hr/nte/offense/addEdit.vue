<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Category">
            <div class="asterisk_label">*</div>
            <vSelect name="category"
                v-model="offense.category"
                :options="selectedCategory"
                label="text"
                v-validate="'required'"
               @input="eventProvision" />
            <div class="pull-right">
                <i v-show="errors.has('category')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('category')" class="help is-danger">{{ errors.first('category') }}</span>
        </form-group>
        <form-group label="Provision">
            <div class="asterisk_label">*</div>
            <vSelect name="provision"
                v-model="offense.provision"
                :options="selectedProvision"
                label="text"
                v-validate="'required'"
                :disabled="provisionDisabled"
                 />
            <div class="pull-right">
                <i v-show="errors.has('provision')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('provision')" class="help is-danger">{{ errors.first('provision') }}</span>
        </form-group>
        <form-group label="Gravity">
            <div class="asterisk_label">*</div>
            <vSelect name="gravity"
                v-model="offense.gravity"
                :options="selectedGravity"
                label="text"
                v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('gravity')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('gravity')" class="help is-danger">{{ errors.first('gravity') }}</span>
        </form-group>
        <form-group label="Corrective Action">
            <div class="asterisk_label">*</div>
            <vSelect name="corrective"
                v-model="offense.corrective_action"
                :options="selectedCorrective"
                label="text"
                v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('corrective')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('corrective')" class="help is-danger">{{ errors.first('corrective') }}</span>
        </form-group>
        <form-group label="Offense">
            <div class="asterisk_label">*</div>
            <textarea class="form-control input-sm" name="offense" placeholder="Please type here..."
                   v-model="offense.offense" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('offense') }" />
            <div class="pull-right">
                <i v-show="errors.has('offense')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('offense')" class="help is-danger">{{ errors.first('offense') }}</span>
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            offenseProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                offense: {
                    offense: '',
                    category: '',
                    provision: '',
                    gravity: '',
                    corrective_action: '',
                },
                selectedCategory: [],
                selectedProvision: [],
                selectedGravity: [],
                selectedCorrective: [],
                provisionDisabled: true,
            };
        },
        created(){
            this.eventCategory();
            this.eventGravity();
            this.eventCorrective();

            if(this.offenseProps.off_id){
                this.offense.category = this.offenseProps.off_category;
                this.offense.provision = this.offenseProps.off_provision;
                this.offense.offense = this.offenseProps.off_offense;
                this.offense.gravity = this.offenseProps.off_gravity;
                this.offense.corrective_action = this.offenseProps.off_corrective_action;
            }
        },
        mounted() {
            this.laddabtn = Ladda.create(document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.offense.category && this.offense.provision && this.offense.offense && this.offense.gravity && this.offense.corrective_action;
            }
        },
        methods: {
            eventCategory(){
                this.$constants.HR_API.get("/dropdown/category")
                    .then(response => {
                        this.selectedCategory = response.data;
                    });
            },
            eventGravity(){
                this.$constants.HR_API.get("/dropdown/gravity")
                    .then(response => {
                        this.selectedGravity = response.data;
                    });
            },
            eventCorrective(){
                this.$constants.HR_API.get("/dropdown/corrective")
                    .then(response => {
                        this.selectedCorrective = response.data;
                    });
            },
            eventProvision(){
                if(this.offense.category.value != undefined){
                    this.provisionDisabled = false;
                    this.$constants.HR_API.get("/dropdown/provision/"+this.offense.category.value)
                    .then(response => {
                        this.selectedProvision = response.data;
                    });  
                }
            },
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let offense = this.offense;
                        let getAxios = '';

                        if(this.offenseProps.off_id){
                            getAxios = this.$constants.HR_API.get("/offense/"+this.offenseProps.off_id, {
                                params: {
                                    category_id: offense.category.value,
                                    provision_id: offense.provision.value,
                                    gravity_id: offense.gravity.value,
                                    corrective_action_id: offense.corrective_action.value,
                                    offense: offense.offense,
                                }
                            });

                        } else {

                            getAxios = this.$constants.HR_API.get("/offense/create", {
                                params: {
                                    category_id: offense.category.value,
                                    provision_id: offense.provision.value,
                                    gravity_id: offense.gravity.value,
                                    corrective_action_id: offense.corrective_action.value,
                                    offense: offense.offense,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.offense = response.data;
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