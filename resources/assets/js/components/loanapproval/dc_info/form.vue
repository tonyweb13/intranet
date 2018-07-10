<template>
    <div class="panel-body">
        <div class="row col-lg-5">
            <form @submit.prevent="submitDC">
                 <form-group label="Portfolio">
                    <div class="asterisk_label">*</div>
                    <vSelect name="portfolio"
                            v-model="dcinfo.portfolio"
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
                    <input class="form-control input-sm" name="loan_id" type="text" placeholder="Loan ID" maxlength="11" v-model="dcinfo.loan_id" v-validate="'required|min:11'" :class="{'input': true, 'is-danger': errors.has('loan_id') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('loan_id')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('loan_id')" class="help is-danger">{{ errors.first('loan_id') }}</span>
                </form-group>
                <form-group label="Name appear on card">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="name" type="text" placeholder="Name appear on card"
                        v-model="dcinfo.name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('name') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
                </form-group>
                <form-group label="16 Digit Number">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="number" type="text" placeholder="16 Digit Number"
                        maxlength="16" v-model="dcinfo.number" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('number') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('number')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('number')" class="help is-danger">{{ errors.first('number') }}</span>
                </form-group>

                 <form-group label="Expiration Date">
                    <div class="asterisk_label">*</div>                    
                    <input class="form-control input-sm" name="expiration_date" type="text" placeholder="MM/YY"
                        v-model="dcinfo.expiration_date" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('expiration_date') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('expiration_date')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('expiration_date')" class="help is-danger">{{ errors.first('expiration_date') }}</span>
                </form-group>

                <form-group label="CVV Code">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="cvv" type="text" placeholder="CVV Code"
                        v-model="dcinfo.cvv" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('cvv') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('cvv')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('cvv')" class="help is-danger">{{ errors.first('cvv') }}</span>
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
                dcinfo: {
                    portfolio: '',
                    loan_id: '',
                    name: '',
                    number: '',
                    expiration_date: '',
                    cvv: '',
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
                return this.dcinfo.portfolio && this.dcinfo.loan_id && this.dcinfo.name && this.dcinfo.expiration_date && this.dcinfo.number && this.dcinfo.cvv ;
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
                        let dcinfo = this.dcinfo;
                        let getAxios = '';

                        getAxios = this.$constants.LoanApp_API.get("/dcinfo/create", {
                            params: {
                                portfolio_id: dcinfo.portfolio.value,
                                loan_id: dcinfo.loan_id,
                                name: dcinfo.name,
                                number: dcinfo.number,
                                expiration_date: dcinfo.expiration_date,
                                cvv_code: dcinfo.cvv
                            }
                        });

                        getAxios.then(response => {
                            this.laddabtn.stop();                            
                            this.$bus.$emit('getDcInfo');
                            this.dcinfo.portfolio = null;
                            this.dcinfo.loan_id = null;
                            this.dcinfo.name = null;
                            this.dcinfo.number = null;
                            this.dcinfo.expiration_date = null;
                            this.dcinfo.cvv = null;
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