<template>
    <div>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row m-b-lg m-t-lg">
                    <div class="col-lg-4 col-md-4">
                        <profile/>
                    </div>
                    <div class="col-md-4">
                        <label>Loan Proces</label>
                        <table class="table small m-b-xs">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>142</strong> Projects
                                </td>
                                <td>
                                    <strong>22</strong> Followers
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <strong>61</strong> Comments
                                </td>
                                <td>
                                    <strong>54</strong> Articles
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>154</strong> Tags
                                </td>
                                <td>
                                    <strong>32</strong> Friends
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <label>Reports & Notifications</label>
                        <table class="table small m-b-xs">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>142</strong> Projects
                                </td>
                                <td>
                                    <strong>22</strong> Followers
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <strong>61</strong> Comments
                                </td>
                                <td>
                                    <strong>54</strong> Articles
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>154</strong> Tags
                                </td>
                                <td>
                                    <strong>32</strong> Friends
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs-container" v-if="employee.address != null && this.employee.government_credential != null 
        && (this.employee.employment_type_id != null && this.employee.date_hired != null && this.employee.regularization_date != null)">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-personal" aria-expanded="true"> Personal</a></li>
                <li class=""><a data-toggle="tab" href="#tab-employment" aria-expanded="false">Employment</a></li>
                <li class=""><a data-toggle="tab" href="#tab-educational" aria-expanded="false">Educational</a></li>
                <li class=""><a data-toggle="tab" href="#tab-government" aria-expanded="false">Government</a></li>
                <li class=""><a data-toggle="tab" href="#tab-details" aria-expanded="false">Details</a></li>
            </ul>
            <div class="tab-content">
                <div class="clearfix"></div>
                <div id="tab-personal" class="tab-pane active">
                    <personal @updateInfo="updatePersonal(employee), editModalPersonal = true"/>
                </div>
                <div class="clearfix"></div>

                <div id="tab-employment" class="tab-pane">
                    <employment @updateInfo="updateEmployment(employee), editModalEmployment = true"/>
                </div>
                <div class="clearfix"></div>

                <div id="tab-educational" class="tab-pane">
                    <educational @updateInfo="updateEducational(employee), editModalEducational = true"/>
                </div>
                <div class="clearfix"></div>

                <div id="tab-government" class="tab-pane">
                    <government @updateInfo="updateGovernment(employee), editModalGovernment = true"/>
                </div>
                <div class="clearfix"></div>

                <div id="tab-details" class="tab-pane">
                    <detail-info @updateInfo="updateDetails(employee), editModalDetails = true"/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <modal v-if="editModalPersonal" @close="editModalPersonal = false">
            <h3 slot="header">Edit Personal Information</h3>
            <edit-personal :personalProps="personal_data" slot="body"/>
        </modal>

        <modal v-if="editModalEmployment" @close="editModalEmployment = false">
            <h3 slot="header">Edit Employment Information</h3>
            <edit-employment :employmentProps="employment_data" slot="body"/>
        </modal>

        <modal v-if="editModalEducational" @close="editModalEducational = false">
            <h3 slot="header">Edit Educational Background</h3>
            <edit-educational :educationalProps="educational_data" slot="body"/>
        </modal>

        <modal v-if="editModalGovernment" @close="editModalGovernment = false">
            <h3 slot="header">Edit Government Information</h3>
            <edit-government :governmentProps="government_data" slot="body"/>
        </modal>

        <modal v-if="editModalDetails" @close="editModalDetails = false">
            <h3 slot="header">Edit Details in case of emergency</h3>
            <edit-details :detailsProps="details_data" slot="body"/>
        </modal>

        <div class="clearfix m-sm"></div>
    </div>
</template>
<script>
    import dashboard from '../dashboard/dashboard.vue'
    import profile from '../tk/employee/profile.vue'
    import editPersonal from '../../components/vps/profile/editPersonal.vue'
    import editEmployment from '../../components/vps/profile/editEmployment.vue'
    import editEducational from '../../components/vps/profile/editEducational.vue'
    import editGovernment from '../../components/vps/profile/editGovernment.vue'
    import editDetails from '../../components/vps/profile/editDetails.vue'
    import personal from '../../components/vps/profile/personal.vue'
    import employment from '../../components/vps/profile/employment.vue'
    import educational from '../../components/vps/profile/educational.vue'
    import government from '../../components/vps/profile/government.vue'
    import detailInfo from '../../components/vps/profile/details.vue'

    export default {
        components: { profile, editPersonal, editEmployment, editEducational, editGovernment, editDetails, personal, employment, educational, government, detailInfo },
        data: function () {
            return {
                employee: this.$session.get('user_session'),
                personal_data: {
                    id: '',
                    gender: '',
                    birthday: '',
                    civil_status: '',
                    mobile_no: '',
                    email_address: '',
                    current_address: '',
                },
                employment_data: {
                    id: '',
                    date_hired: '',
                    regularization_date: '',
                    employment_type: '',
                },
                educational_data: {
                    educational_id: '',
                    course: '',
                    educational_institution: '',
                    year_graduated: '',
                },
                government_data: {
                    id: '',
                    phil_health_number: '',
                    hmdf_number: '',
                    sss_number: '',
                    tin_number: '',
                },
                details_data: {
                    details_id: '',
                    person_to_contact_in_case_of_emergency: '',
                    relationship: '',
                    contact_person_no: '',
                },
                editModalPersonal: false,
                editModalEmployment: false,
                editModalEducational: false,
                editModalGovernment: false,
                editModalDetails: false,
            };
        },
        created() {
            this.$bus.$on('init_modal', (param) => {
                this.editModalPersonal = param;
                this.editModalEmployment = param;
                this.editModalEducational = param;
                this.editModalGovernment = param;
                this.editModalDetails = param;
            });

            if(this.employee.address == null){
                    swal({
                        title:'Please fill up Address Information Form',
                        type: "error",
                        text: "You don't have any information in your address",
                    });

                    this.editModalPersonal = true; 
                    this.updatePersonal(this.employee);

            } else if(this.employee.government_credential == null){
                    swal({
                        title:'Please fill up Government Credential Form',
                        type: "error",
                        text: "You don't have any information in your government credential",
                    });

                    this.editModalGovernment = true;
                    this.updateGovernment(this.employee);

            } else if(this.employee.employment_type_id == null || this.employee.date_hired == null || this.employee.regularization_date == null){
                    swal({
                        title:'Please fill up Employment Type Form',
                        type: "error",
                        text: "You don't have any information in your employment type",
                    });

                    this.editModalEmployment = true; 
                    this.updateEmployment(this.employee);

            }
        },
        methods: {
            updatePersonal: function(employee) {
                this.personal_data.id = employee.id;
                this.personal_data.gender = employee.gender;
                this.personal_data.birthday = employee.birthday;
                this.personal_data.civil_status = employee.civil_status;
                this.personal_data.mobile_no = employee.mobile_no;
                this.personal_data.email_address = employee.email_address;
                this.personal_data.current_address = employee.address.current_address;
            },
            updateEmployment: function(employee) {
                this.employment_data.id = employee.id;
                this.employment_data.date_hired = employee.date_hired;
                this.employment_data.regularization_date = employee.regularization_date;
                this.employment_data.employment_type = employee.employment_type.name;
            },
            updateEducational: function(employee) {
                this.educational_data.id = employee.id;
                this.educational_data.course = employee.course;
                this.educational_data.educational_institution = employee.educational_institution;
                this.educational_data.year_graduated = employee.year_graduated;
            },
            updateGovernment: function(employee) {
                this.government_data.id = employee.id;
                this.government_data.phil_health_number = employee.government_credential.phil_health_number;
                this.government_data.hmdf_number = employee.government_credential.hmdf_number;
                this.government_data.sss_number = employee.government_credential.sss_number;
                this.government_data.tin_number = employee.government_credential.tin_number;
            },
            updateDetails: function(employee) {
                this.details_data.id = employee.id;
                this.details_data.person_to_contact_in_case_of_emergency = employee.person_to_contact_in_case_of_emergency;
                this.details_data.relationship = employee.relationship;
                this.details_data.contact_person_no = employee.contact_person_no;
            },
        }
    }
</script>