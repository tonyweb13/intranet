<template>
    <div class="panel-body">
        <div class="row col-lg-5">
            <form @submit.prevent="submitDC">
                 <form-group label="Portfolio ID">
                    <div class="asterisk_label">*</div>
                    <vSelect name="is enable"
                            v-model="adj.portfolio"
                            :options="selectedIsEnable"
                            label="text"
                            v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('portfolio')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('portfolio')" class="help is-danger">{{ errors.first('portfolio') }}</span>
                </form-group>
                <form-group label="Loan ID">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="loan_id" type="text" placeholder="Loan ID" maxlength="11" v-model="adj.loan_id" v-validate="'required|min:11'" :class="{'input': true, 'is-danger': errors.has('loan_id') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('loan_id')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('loan_id')" class="help is-danger">{{ errors.first('loan_id') }}</span>
                </form-group>
                <save-button :disabled='!isComplete' />
            </form>
        </div>
    </div>
</template>
<script>

    export default {
        data: function (){
            return {
                adj: {
                    portfolio: '',
                    loan_id: '',
                },
                selectedIsEnable: [],
                laddabtn : '',
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.adj.portfolio && this.adj.loan_id;
            },
        },
        created() {
            this.getPorfolio();
        },
        methods: {            
            getPorfolio: function () {
                this.$constants.Settings_API.get('/portfolio/dropdown')
                    .then(response => {
                        this.selectedIsEnable  = response.data;
                    });
            },
            submitDC: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let adj = this.adj;
                        let getAxios = '';

                        getAxios = this.$constants.LoanApp_API.get("/adjustmentfinancefee/create", {
                            params: {
                                portfolio: adj.portfolio.text,
                                loan_id: adj.loan_id,
                            }
                        });

                        getAxios.then(response => {
                            this.laddabtn.stop();                            
                            this.$bus.$emit('getAdjFee');
                            this.adj.portfolio = null;
                            this.adj.loan_id = null;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                        }).then(() => {
                            this.$validator.reset();
                        }).catch(error => {
                            this.laddabtn.stop();
                            swal({
                                text: error,
                                type: "error",
                            });
                        });
                    }
                })
            }
        }
    }

</script>