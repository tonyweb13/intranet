<template>
    <div>
        <div class="panel-body">
            <div class="row" >
                <div class="col-lg-12">
                    <h2 v-if="portfolioProps == 3" > {{ portfolioTitle }}</h2>
                    <h2 v-else-if="portfolioProps == 4" > {{ portfolioTitle }}</h2>
                    <h2 v-else-if="portfolioProps == 5" > {{ portfolioTitle }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <label>To view Agents, select Team Leader below</label>

                    <label class="checkbox-container">
                        <input type="checkbox" v-model="selectAll"> <p style="font-weight: 100;">Select All - check / uncheck</p>
                        <span class="checkbox-checkmark"></span>
                    </label>
                    <label class="checkbox-container" v-for="teamlead in teamleads">
                      <input type="checkbox" v-model="teamSelected" @click="checkedTeam(teamlead.employee_no)" :value="teamlead.employee_no">
                        <p style="font-weight: 100;">{{ teamlead.first_name }} {{ teamlead.last_name }}</p>
                      <span class="checkbox-checkmark"></span>
                    </label>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-12" v-if="teamSelected.length == teamleads.length || selectedSingle == true">
                    <hr>
                    <p class="small">
                        <i class="fa fa-hand-point-up"></i> 
                        <span class="m-r-xs">Drag Agent Name between Team Leader</span> 
                        ( <span style="color:red;"><b>Note</b></span>: <i>Any changes will save automatically</i> ) 
                    </p>
                </div> 

                <div class="col-lg-3" v-if="teamSelected.length == teamleads.length" v-for="teamlead in teamleads">
                     <div class="ibox">
                         <div class="custom-box-color">
 
                             <div class="cursor-expand" data-toggle="collapse" :data-target="'#'+teamlead.employee_no">        
                                 <img alt="image" class="custom-primary-photo"
                                 v-if="teamlead.profile_pic" :src="'/img/profile/'+teamlead.profile_pic">
                                 <img alt="image" class="custom-primary-photo" v-else :src="'/img/profile_small.jpg'">
 
                                 <small><b>{{ teamlead.first_name }} {{ teamlead.last_name }}</b></small>

                                 <div class="pull-right"><i class="fas fa-angle-double-down"></i></div>
                             </div>
 
                             <draggable :id="teamlead.employee_no" class="custom-draggable collapse" :list="teamlead.members" 
                             :options="{animation:200, group:'employee_no'}" :element="'article'" @change="updateGroups">
 
                                 <article class="custom-draggable-success" v-for="member in teamlead.members" 
                                 :key="member.employee_no" v-if="member.get_user_info && member.get_user_info.first_name != null && member. get_user_info.last_name != null">
 
                                 <img alt="image" class="custom-primary-photo" v-if="member.get_user_info && member.get_user_info.profile_pic" :src ="'/img/profile/'+member.get_user_info.profile_pic" >
                                 <img alt="image" v-else :src="'/img/profile_small.jpg'" class="custom-primary-photo" >
 
                                    <small v-if="member.get_user_info">
                                         {{ member.get_user_info.first_name }} {{ member.get_user_info.last_name }}
                                    </small>
                                 </article>
                             </draggable>
 
                         </div>
                     </div>
                </div>

                <div class="col-lg-3" v-if="selectedSingle == true" v-for="teamlead in teamleadSingles">
                    <div class="ibox">
                        <div class="custom-box-color">

                        <div class="cursor-expand" data-toggle="collapse" :data-target="'#'+teamlead.employee_no"> 
                            <img alt="image" class="custom-primary-photo"
                            v-if="teamlead.profile_pic" :src="'/img/profile/'+teamlead.profile_pic">
                            <img alt="image" class="custom-primary-photo" v-else :src="'/img/profile_small.jpg'">

                            <small><b>{{ teamlead.first_name }} {{ teamlead.last_name }}</b></small>

                            <div class="pull-right"><i class="fas fa-angle-double-down"></i></div>
                        </div>

                        <draggable :id="teamlead.employee_no" class="custom-draggable collapse" :list="teamlead.members" 
                        :options="{animation:200, group:'employee_no'}" :element="'article'" @change="updateGroups">

                            <article class="custom-draggable-success" v-for="member in teamlead.members" 
                            :key="member.employee_no" v-if="member.get_user_info && member.get_user_info.first_name != null && member.get_user_info.last_name != null">

                            <img alt="image" class="custom-primary-photo" v-if="member.get_user_info && member.get_user_info.profile_pic" :src="'/img/profile/'+member.get_user_info.profile_pic" >
                            <img alt="image" v-else :src="'/img/profile_small.jpg'" class="custom-primary-photo" >

                               <small v-if="member.get_user_info">
                                    {{ member.get_user_info.first_name }} {{ member.get_user_info.last_name }}
                               </small>
                            </article>
                        </draggable>

                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: { portfolioProps: Number },
        data: function () {
            return {
                teamleads: {},
                portfolios: {},
                portfolioTitle: '',
                teamleadSingles: {},
                teamSelected: [],
                selectedSingle: false,
            }
        },
        created() {

            let getSetting = '';
            if(this.portfolioProps == 3){

                this.portfolioTitle = 'Solid Oak Finance - (SOF)';
                getSetting = this.$constants.Settings_API.get("/usersgroups/portfolio/"+this.portfolioProps);

            } else if(this.portfolioProps == 4){

                this.portfolioTitle = 'Inbox Loan - (INBX)';
                getSetting = this.$constants.Settings_API.get("/usersgroups/portfolio/"+this.portfolioProps);

            } else if(this.portfolioProps == 5){
                
                this.portfolioTitle = 'Comet Loan - (COMET)';
                getSetting = this.$constants.Settings_API.get("/usersgroups/portfolio/"+this.portfolioProps);

            }

            getSetting.then(response => {
                this.teamleads = response.data;  
            });
        },
        computed: {
            selectAll: {
                get: function () {
                    if(this.teamleads){
                        if(this.teamSelected.length == this.teamleads.length){

                             this.selectedSingle = false;
                             return true;

                        } else {

                            return false;
                        }
                    }
                },
                set: function (value) {

                    let teamSelected = [];

                    if (value) {
                        this.selectedSingle = false;

                        this.teamleads.forEach(function (teamlead) {
                            teamSelected.push(teamlead.employee_no);
                        });
                    }

                    this.teamSelected = teamSelected;
                }
            },
        },
        methods: {
            updateGroups() {

                let getSelectedTeamleads = '';   

                if(this.teamSelected.length == this.teamleads.length){

                    getSelectedTeamleads = this.teamleads;

                } else if(this.selectedSingle == true){

                    getSelectedTeamleads = this.teamleadSingles;
                }

                    getSelectedTeamleads.map((member) => {

                        for(let m = 0; m < member.members.length; m++){

                            if(member.employee_no != member.members[m].teamlead_employee_no){

                                let newTeamlead = member.employee_no;
                                let oldTeamlead = member.members[m].teamlead_employee_no;
                                let agent = member.members[m].employee_no;

                                    this.$constants.Settings_API.put('/usersgroups/updates', {
                                        teamlead_employee_no: newTeamlead,
                                        employee_no: agent
                                    }).then((response) => {
                                        console.log(response.data);
                                    }).catch((error) => {
                                        console.log(error);
                                    })
                            } 
                        }    
                    });

            },
            checkedTeam(employeeNo) {

                this.selectedSingle = true;
                this.teamSelected.push(employeeNo);

                this.$constants.Settings_API.get("/usersgroups/teamlead/"+this.portfolioProps, {
                params: {
                            employee_no: this.teamSelected,
                        }
                }).then(response => {

                    this.teamleadSingles = response.data;
                });
            }
        }
    }
</script>