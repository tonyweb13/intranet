<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="category.name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="category.description" />
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            categoryProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                category: {
                    name: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.categoryProps.cat_id){
                this.category.name = this.categoryProps.cat_name;
                this.category.description = this.categoryProps.cat_desc;
            } else {
                this.category.name = '';
                this.category.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create(document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.category.name && this.category.description;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let category = this.category;
                        let getAxios = '';

                        if(this.categoryProps.cat_id){

                            getAxios = this.$constants.HR_API.get("/nte/category/"+this.categoryProps.cat_id, {
                                params: {
                                    name: category.name,
                                    description: category.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.HR_API.get("/nte/category/create", {
                                params: {
                                    name: category.name,
                                    description: category.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.category = response.data;
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