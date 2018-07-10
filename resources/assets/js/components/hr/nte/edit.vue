0<template>
        <div class="ibox-content p-xl">
            <div class="row">
                <div class="col-lg-2">
                    <img alt="image" class="img-responsive" :src="logo">
                </div>
                <div class="pull-right text-right">
                    <small>14th Floor Net Square Building</small><br>
                    <small>3<sup>rd</sup> Avenue corner E-Square, Crescent Park</small><br>
                    <small>West, 28<sup>th</sup> St. Taguig, 1643 Metro Manila</small><br><br>
                    <strong style="color: #f56c6c;">HR FORM - 014</strong>
                    <div class="title-action">
                        <el-button class="btn btn-white" v-on:click="form = !form, save =!save"><i class="fa fa-pencil"></i> Edit</el-button>
                        <el-button class="btn btn-white ladda-button" v-if="save" v-on:click="updateNteform()" data-color="mint" data-style="slide-right"><i class="fa fa-check "></i> Save</el-button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <u><h4 class="text-center">NOTICE TO EXPLAIN</h4></u>
                    <br>
                    <br>
                    <strong></strong><br>
                    <br>
                    <br>
                    <address>
                        <strong></strong><br>
                        <strong></strong><br>
                        <strong></strong><br>
                        <strong></strong><br>
                        <br>
                        Dear ,
                    </address>
                </div>
                <div class="col-lg-12">
                    <custom-textarea v-model="infos.description" v-if="form">
                    </custom-textarea>
                    <p>{{ infos.description }}
                    </p>
                </div>
                <div class="col-lg-12 table-responsive m-t">
                    <table class="table table-bordered">
                        <thead >
                            <tr>
                                <th>Criteria</th>
                                <th>Target Loan Amount</th>
                                <th>Actual Loan Amount</th>
                                <th>Target</th>
                                <th>Actual</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:20%;"></td>
                                <td style="width:20%;"></td>
                                <td style="width:20%;"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    <p>
                        If proven, this may constitute a violation of the Company Policy/Code of Conduct to wit:
                    </p>
                </div>
                <div class="col-lg-12 table-responsive m-t">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Provision</th>
                                <th>Offense</th>
                                <th>Gravity</th>
                                <th>Corrective Action(on 1<sup>st</sup> Occurrence)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-offset-10 col-lg-2">
                    <div class="title-action">
                        
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    import axios from 'axios'

    export default {
        data: function () {
            return {
                laddabtn : '',
                logo: '',
                form: false,
                save: false,
                infos: [],
            }
        },
        created() {
           this.logo = '../../../img/arb.jpg';
           this.getInfo();
        },
        methods: {
            getInfo: function () {
                this.$constants.HR_API.get('/ntelistform/' + this.$route.params.nte_id)
                .then(response => {
                    this.infos = response.data;
                });
            },
            updateNteform: function () {
                this.$constants.HR_API.get('/ntelistform/' + this.$route.params.nte_id, { 
                    params: {
                        description: this.infos.description,
                }})
                .then(response => {
                    this.form = false;
                    swal('','Successfully updating nte form!','success');
                    
                })
                .catch(errors => {
                    console.log(errors);
                });
            }
        }
    }

</script>
