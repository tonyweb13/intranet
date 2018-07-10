<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="portfolio.name" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description"
                   v-model="portfolio.description" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('description') }" />
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
        props: {
            portfolioProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                portfolio: {
                    name: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.portfolioProps.portfolio_id){
                this.portfolio.name = this.portfolioProps.portfolio_name;
                this.portfolio.description = this.portfolioProps.portfolio_description;
            } else {
                this.portfolio.name = '';
                this.portfolio.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.portfolio.name;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let portfolio = this.portfolio;
                        let getAxios = '';

                        if(this.portfolioProps.portfolio_id){

                            getAxios = this.$constants.Settings_API.get("/portfolio/"+this.portfolioProps.portfolio_id, {
                                params: {
                                    name: portfolio.name,
                                    description: portfolio.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.Settings_API.get("/portfolio/create", {
                                params: {
                                    name: portfolio.name,
                                    description: portfolio.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.portfolio = response.data;
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