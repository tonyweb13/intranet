<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Provision">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="provision" type="text" placeholder="Provision"
                   v-model="provision.provision" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('provision') }" >
            <div class="pull-right">
                <i v-show="errors.has('provision')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('provision')" class="help is-danger">{{ errors.first('provision') }}</span>
        </form-group>
        <form-group label="Category">
            <vSelect name="category"
                v-model="provision.category"
                :options="selectedCategory"
                label="text"
                v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('category')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('category')" class="help is-danger">{{ errors.first('category') }}</span>
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            provisionProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                provision: {
                    provision: '',
                    category: '',
                },
                selectedCategory: []
            };
        },
        created(){
            this.eventCategory();

            if(this.provisionProps.prov_id){
                this.provision.provision = this.provisionProps.prov_provision;
                this.provision.category = this.provisionProps.prov_category;
            } else {
                this.provision.provision = '';
                this.provision.category = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create(document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.provision.provision && this.provision.category;
            }
        },
        methods: {
            eventCategory(){
                this.$constants.HR_API.get("/dropdown/category")
                    .then(response => {
                        this.selectedCategory = response.data;
                    });
            },
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let provision = this.provision;
                        let getAxios = '';

                        if(this.provisionProps.prov_id){

                            getAxios = this.$constants.HR_API.get("/provision/"+this.provisionProps.prov_id, {
                                params: {
                                    provision: provision.provision,
                                    category_id: provision.category.value,
                                }
                            });

                        } else {

                            getAxios = this.$constants.HR_API.get("/provision/create", {
                                params: {
                                    provision: provision.provision,
                                    category_id: provision.category.value,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.provision = response.data;
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