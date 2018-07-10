<template>  
    <div class="row" id="for-print">  
        <form @submit.prevent="submitForm">
            <div class="col-lg-2">
                <img alt="image" class="img-responsive" :src="logo">
            </div>
            <div class="pull-right text-right">
                    <small>14th Floor Net Square Building</small><br>
                    <small>3<sup>rd</sup> Avenue corner E-Square, Crescent Park</small><br>
                    <small>West, 28<sup>th</sup> St. Taguig, 1643 Metro Manila</small><br><br>
                    <strong style="color: #f56c6c;">{{ ntelistform }} </strong>  
                    <div class="title-action">
                        <a @click="printPreview" class="btn btn-primary"><i class="fa fa-print"></i> Print NTE </a>
                    </div>               
            </div>
            <div class="col-lg-12" v-for="nte in infoProps" v-bind:key="nte.employee_id">
                <u><h4 class="text-center">NOTICE TO EXPLAIN</h4></u>
                <br>
                <br>
                <strong>{{ nte.date }}</strong><br>
                <br>
                <br>
                <address>
                    <strong>{{ nte.first_name + ' ' +nte.last_name }}</strong><br>
                    <strong>{{ nte.employee_id }}</strong><br>
                    <strong>{{ designation }}</strong><br>
                    <strong>{{ department }}</strong><br>
                    <br>
                    Dear {{ nte.first_name }},
                </address>
            </div>
            <div class="col-lg-12" v-for="desc in descriptions" v-bind:key="desc.id">     
                <p >
                   {{ desc.description }} 
                </p>
            </div>
            
            <nte-table/>
           
            <div class="col-lg-12">
                <p>
                    If proven, this may constitute a violation of the Company Policy/Code of Conduct to wit:
                </p>
            </div>
            <div class="col-lg-12">
                <table class="table table-bordered table-responsive m-t">
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
                            <td style="width:7%;" >
                                <vSelect name="provisions"
                                        v-model="infoNte.provision"
                                        :options="provisions"
                                        label="text"
                                        :on-change="getOffense()"
                                />
                            </td>
                            <td style="width:10%;">
                                <div>
                                    {{ offense }}
                                </div>
                            </td>
                            <td style="width:7%;">
                                <vSelect name="gravitys"
                                        v-model="infoNte.gravity"
                                        :options="gravitys"
                                        label="text"
                                        :on-change="getGravity()"
                                />
                            </td>
                            <td style="width:10%;">
                                {{ gravity }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-offset-10 col-lg-2">
                <div class="title-action">
                    <button class="btn btn-default"><i class="fa fa-paper-plane"></i> Send NTE</button>
                </div>
            </div>
        </form>
    </div>
</template>
<style scoped>
    @media print {
         button {
            display: none !important;
        }
        .el-input__inner{
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
        }
        button, a, .border-bottom, .footer, h2 {
            display: none;            
        }
        #for-print {
            display: block;
        }
        @page { margin: 0mm; size: auto; }
    }
</style>
<script>
    import nteTable from '../../../components/hr/nte/table_components.vue'

    export default {
        components: { nteTable },
        data: function(){
            return {
                logo: '',
                offense: '',
                designation: '',
                department: '',
                gravity: '',
                ntelistform: '',
                infoNte: {
                    provision: '',
                    gravity: ''
                },
                descriptions: [],
                provisions: [],
                gravitys: [],
            }
        },
        props: {
            infoProps: Array
        },
        mounted () {
            
        },
        created() {
           this.logo = '../../../img/arb.jpg';
           this.fetchProvisions();
           this.fetchGravity();
           this.fetchDescription();
           this.$constants.Settings_API.get('/designation/' + this.infoProps[0]['role'])
                .then(response => {
                    this.designation = response.data.name;
                });
            this.$constants.Settings_API.get('/department/' + this.infoProps[0]['department'])
                .then(response => {
                    this.department = response.data.name;
                });
            this.$constants.HR_API.get('/ntelistform/' + this.infoProps[0]['nte_type'])
                .then(response => {
                    this.ntelistform = response.data.name;
                });
        },
        methods: {
            getOffense: function () {
                var off;
                let info = this.infoNte;
                if(info.provision) {
                    this.provisions.forEach(function(val, index) {
                        if (info.provision.value === val.value) {
                            off = val.offense;
                        }
                    });
                }
               
                this.offense = off;
            },
            getGravity: function () {
                var grav;
                let info = this.infoNte;
                if(info.gravity) {
                    this.gravitys.forEach(function(val, index) {
                        if (info.gravity.value === val.value) {
                            grav = val.desc;
                        }
                    });
                }

               this.gravity = grav;
            },
            fetchDescription: function () {
                return this.$constants.HR_API.get('/ntelist/' + this.infoProps[0]['nte_type'])
                .then(response => {                    
                    this.descriptions = response.data;
                })
                .catch(errors =>{
                    swal('',errors, 'danger');
                });
            },
            fetchProvisions: function () {
                return this.$constants.HR_API.get('/dropdown/provision')
                .then(response => {
                    this.provisions = response.data;
                })
                .catch(errors =>{
                    swal('',errors, 'danger');
                });
            },
            fetchGravity: function () {
                return this.$constants.HR_API.get('/dropdown/gravity')
                .then(response => {
                    this.gravitys = response.data;
                })
                .catch(errors =>{
                    swal('',errors, 'danger');
                });
            },
            // submitForm(){
            //     this.$validator.validateAll().then((result) => {
            //         if (result) {
            //             window.alert('weww');
            //         }
            //     });
            // },
            printPreview: function () {
                window.print();
            }
        }
    }
</script>