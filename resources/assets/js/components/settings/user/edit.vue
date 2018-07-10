<template>
    <div class="row ibox-content">
        <form @submit.prevent="eventUpdate" style="height: 870px;">
            <div class="col-lg-12">           
                <h4><i class="fa fa-user"> </i> Personal Information </h4>
                <hr>
                <form-group label="First Name" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="fname" type="text" placeholder="First Name"
                            v-model="emp.first_name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('fname') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('fname')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('fname')" class="help is-danger">{{ errors.first('fname') }}</span>
                </form-group>
                <form-group label="Last Name" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="lname" type="text" placeholder="Last Name"
                            v-model="emp.last_name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('lname') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('lname')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('lname')" class="help is-danger">{{ errors.first('lname') }}</span>
                </form-group>
                <form-group label="Birthday" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control input-sm" name="birthday" id="editBirthday" v-model="emp.birthday"  placeholder="YYYY-MM-DD"
                                v-validate="'required|date_format:YYYY-MM-DD'" :class="{'input': true, 'is-danger': errors.has('birthday') }">
                    </div>
                    <div class="pull-right">
                        <i v-show="errors.has('birthday')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('birthday')" class="help is-danger">{{ errors.first('birthday') }}</span>
                </form-group>
                <form-group label="Date Hired" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control input-sm" name="date hired" id="editHired" v-model="emp.date_hired"  placeholder="YYYY-MM-DD"
                                v-validate="'required|date_format:YYYY-MM-DD'" :class="{'input': true, 'is-danger': errors.has('date hired') }">
                    </div>
                    <div class="pull-right">
                        <i v-show="errors.has('date hired')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('date hired')" class="help is-danger">{{ errors.first('date hired') }}</span>
                </form-group>
                <form-group label="Mobile Number" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input type="number" class="form-control input-sm" name="mobile" v-model="emp.mobile_no"  placeholder="Mobile Number"
                                v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('mobile') }">
                    <div class="pull-right">
                        <i v-show="errors.has('mobile')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('mobile')" class="help is-danger">{{ errors.first('mobile') }}</span>
                </form-group>
                <form-group label="Gender" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <vSelect name="gender"
                                v-model="emp.gender"
                                :options="selectedGender"
                                label="text"
                                v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('gender')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('gender')" class="help is-danger">{{ errors.first('gender') }}</span>
                </form-group>
                <form-group label="Email address" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="email" type="email" placeholder="Email address"
                            v-model="emp.email_address" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('email') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('email')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('email')" class="help is-danger">{{ errors.first('email') }}</span>
                </form-group>
                <form-group label="Civil Status" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <vSelect name="civil_status"
                                v-model="emp.civil_status"
                                :options="selectedCivilStatus"
                                label="text"
                                v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('civil_status')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('civil_status')" class="help is-danger">{{ errors.first('civil_status') }}</span>
                </form-group>
                    <form-group label="Current Address" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <textarea type="text" class="form-control input-sm" name="address" v-model="emp.address.current_address"  placeholder="Current Address"
                            v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('address') }" />
                    <div class="pull-right">
                        <i v-show="errors.has('address')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('address')" class="help is-danger">{{ errors.first('address') }}</span>
                </form-group>
            </div>
            <div class="col-lg-12">
                <h4><i class="fa fa-suitcase"> </i> Employment Information</h4>
                <hr>
                <form-group label="PhilHealth Number" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input type="number" class="form-control input-sm" name="philHealth number" v-model="emp.government_credential.phil_health_number"  placeholder="PhilHealth Number"
                            v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('philHealth number') }">
                    <div class="pull-right">
                        <i v-show="errors.has('philHealth number')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('philHealth number')" class="help is-danger">{{ errors.first('philHealth number') }}</span>
                </form-group>
                <form-group label="Pag-ibig Number" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input type="number" class="form-control input-sm" name="pagibig number" v-model="emp.government_credential.hmdf_number"  placeholder="Pag-ibig Number"
                            v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('pagibig number') }">
                    <div class="pull-right">
                        <i v-show="errors.has('pagibig number')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('pagibig number')" class="help is-danger">{{ errors.first('pagibig number') }}</span>
                </form-group>
                <form-group label="SSS Number" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input type="number" class="form-control input-sm" name="sss number" v-model="emp.government_credential.sss_number"  placeholder="SSS Number"
                            v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('sss number') }">
                    <div class="pull-right">
                        <i v-show="errors.has('sss number')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('sss number')" class="help is-danger">{{ errors.first('sss number') }}</span>
                </form-group>
                <form-group label="TIN Number" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input type="number" class="form-control input-sm" name="tin number" v-model="emp.government_credential.tin_number"  placeholder="TIN Number"
                            v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('tin number') }">
                    <div class="pull-right">
                        <i v-show="errors.has('tin number')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('tin number')" class="help is-danger">{{ errors.first('tin number') }}</span>
                </form-group>
                <form-group label="Employment Type" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <vSelect name="employment type"
                                v-model="emp.employment_type.name"
                                :options="selectedEmploymentType"
                                label="text"
                                v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('employment type')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('employment type')" class="help is-danger">{{ errors.first('employment type') }}</span>
                </form-group>
                <form-group label="Department" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <vSelect name="department"
                                v-model="emp.department.name"
                                :options="selectedDepartment"
                                label="text"
                                v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('department')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('department')" class="help is-danger">{{ errors.first('department') }}</span>
                </form-group>
                <form-group label="Designation" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <vSelect name="designation"
                                v-model="emp.designation.name"
                                :options="selectedDesignation"
                                label="text"
                                v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('designation')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('designation')" class="help is-danger">{{ errors.first('designation') }}</span>
                </form-group>
                <form-group label="Regularization Date" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control input-sm" name="regularization date" id="editRegularization" v-model="emp.regularization_date"  placeholder="YYYY-MM-DD"
                                v-validate="'required|date_format:YYYY-MM-DD'" :class="{'input': true, 'is-danger': errors.has('regularization date') }">
                    </div>
                    <div class="pull-right">
                        <i v-show="errors.has('regularization date')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('regularization date')" class="help is-danger">{{ errors.first('regularization date') }}</span>
                </form-group>
            </div>
            <div class="col-lg-12">
                <h4><i class="fa fa-university"> </i> Educational Information</h4>
                <hr>
                    <form-group label="Course" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="course" type="text" placeholder="Course"
                            v-model="emp.course" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('course') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('course')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('course')" class="help is-danger">{{ errors.first('course') }}</span>
                </form-group>
                <form-group label="Educational Institution" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="educational institution" type="text" placeholder="Educational Institution"
                            v-model="emp.educational_institution" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('educational institution') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('educational institution')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('educational institution')" class="help is-danger">{{ errors.first('educational institution') }}</span>
                </form-group>
                <form-group label="Year Graduated" class="col-lg-4">
                    <div class="asterisk_label">*</div>
                    <vSelect name="year graduated"
                                v-model="emp.year_graduated"
                                :options="selectedYear"
                                label="text"
                                v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('year graduated')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('year graduated')" class="help is-danger">{{ errors.first('year graduated') }}</span>
                </form-group>
            </div>
            <div class="col-lg-12">
                <h4><i class="fa fa-phone"> </i> In case of Emergency Contact</h4>
                <hr>
                    <form-group label="Person to contact in case of emergency" class="col-lg-4">
                    <input class="form-control input-sm" name="person_to_contact_in_case_of_emergency" type="text" placeholder="Person to contact in case of emergency"
                            v-model="emp.person_to_contact_in_case_of_emergency" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Person to contact in case of emergency') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('Person to contact in case of emergency')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('Person to contact in case of emergency')" class="help is-danger">{{ errors.first('Person to contact in case of emergency') }}</span>
                </form-group>
                <form-group label="Relationship to contact person" class="col-lg-4">
                    <input class="form-control input-sm" name="relationship" type="text" placeholder="Relationship to contact person"
                            v-model="emp.relationship" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Relationship to contact person') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('Relationship to contact person')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('Relationship to contact person')" class="help is-danger">{{ errors.first('Relationship to contact person') }}</span>
                </form-group>
                <form-group label="Contact person number" class="col-lg-4">
                    <input class="form-control input-sm" name="contact_person_no" type="text" placeholder="Contact person number"
                            v-model="emp.contact_person_no" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Contact person number') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('Contact person number')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('Contact person number')" class="help is-danger">{{ errors.first('Contact person number') }}</span>
                </form-group>
                <div class="pull-right" style="margin-right: 15px;">
                    <button class="ladda-button btn btn-primary " type="submit" :disabled="!isComplete" data-color="mint" data-style="slide-right">Update</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                laddabtn : '',
                emp: {
                    department:{},
                    designation:{},
                    employment_type:{},
                    address:{},
                    government_credential:{},
                },
                selectedDepartment: [],
                selectedDesignation: [],
                selectedEmploymentType: [],
                selectedGender: [
                    { text: 'Male', value: 'Male'},
                    { text: 'Female', value: 'Female'},
                ],
                selectedCivilStatus:[
                    { text: 'Single', value: 'Single'},
                    { text: 'Married', value: 'Married'},
                    { text: 'Divorced', value: 'Divorced'},
                    { text: 'Separated', value: 'Separated'},
                    { text: 'Widowed', value: 'Widowed'},
                ],
                selectedYear: [
                    { text: '2018', value: '2018' },
                    { text: '2017', value: '2017' },
                    { text: '2016', value: '2016' },
                    { text: '2015', value: '2015' },
                    { text: '2014', value: '2014' },
                    { text: '2013', value: '2013' },
                    { text: '2012', value: '2012' },
                    { text: '2011', value: '2011' },
                    { text: '2010', value: '2010' },
                    { text: '2009', value: '2009' },
                    { text: '2008', value: '2008' },
                    { text: '2007', value: '2007' },
                    { text: '2006', value: '2006' },
                    { text: '2005', value: '2005' },
                    { text: '2004', value: '2004' },
                    { text: '2003', value: '2003' },
                    { text: '2002', value: '2002' },
                    { text: '2001', value: '2001' },
                    { text: '2000', value: '2000' },
                    { text: '1999', value: '1999' },
                    { text: '1998', value: '1998' },
                    { text: '1997', value: '1997' },
                    { text: '1996', value: '1996' },
                    { text: '1995', value: '1995' },
                    { text: '1994', value: '1994' },
                    { text: '1993', value: '1993' },
                    { text: '1992', value: '1992' },
                    { text: '1991', value: '1991' },
                    { text: '1990', value: '1990' },
                    { text: '1989', value: '1989' },
                    { text: '1988', value: '1988' },
                    { text: '1987', value: '1987' },
                    { text: '1986', value: '1986' },
                    { text: '1985', value: '1985' },
                    { text: '1984', value: '1984' },
                    { text: '1983', value: '1983' },
                    { text: '1982', value: '1982' },
                    { text: '1981', value: '1981' },
                ],
            }
        },
        props: {
            employeeProps: Object,
            labels: {
                type: Object,
                default () {
                    return {
                        save: 'Save',
                        cancel: 'Close'
                    }
                }
            },
        },
        created() {
            this.$constants.Settings_API.get("/employee/"+this.$route.params.employee_id+"/edit")
                .then(response => {
                this.emp = response.data;
            });

            this.$constants.Settings_API.get("/department/dropdown")
                .then(response => {
                    this.selectedDepartment = response.data;
                });

            this.$constants.Settings_API.get("/designation/dropdown")
                .then(response => {
                    this.selectedDesignation = response.data;
                });

            this.$constants.Settings_API.get("/employment_type/dropdown")
                .then(response => {
                    this.selectedEmploymentType = response.data;
                });
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));

            $("#editBirthday").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                }
            ).on(
                "changeDate", () => {
                    this.emp.birthday = $("#editBirthday").val();
                }
            );

            $("#editHired").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                }
            )
                .on(
                    "changeDate", () => {
                        this.emp.date_hired = $("#editHired").val();
                    }
                );

            $("#editRegularization").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                }
            )
                .on(
                    "changeDate", () => {
                        this.emp.regularization_date = $("#editRegularization").val();
                    }
                );
        },
        computed: {
            isComplete () {
                return this.emp.first_name && this.emp.last_name && this.emp.department.name && this.emp.designation.name && this.emp.email_address
                    && this.emp.gender && this.emp.civil_status && this.emp.birthday && this.emp.mobile_no && this.emp.address.current_address
                    && this.emp.date_hired && this.emp.regularization_date && this.emp.employment_type.name && this.emp.course && this.emp.educational_institution
                    && this.emp.year_graduated && this.emp.government_credential.phil_health_number && this.emp.government_credential.phil_health_number
                    && this.emp.government_credential.hmdf_number && this.emp.government_credential.sss_number  && this.emp.government_credential.tin_number;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                        if (result) {
                            this.laddabtn.start();
                            let emp = this.emp;

                            this.$constants.Settings_API.get("/employee/"+this.emp.id, {
                                params: {
                                    first_name: emp.first_name,
                                    last_name: emp.last_name,
                                    department_id: emp.department.name.value,
                                    designation_id: emp.designation.name.value,
                                    email_address: emp.email_address,
                                    gender: emp.gender.value,
                                    civil_status: emp.civil_status.value,
                                    birthday: emp.birthday,
                                    mobile_no: emp.mobile_no,
                                    date_hired: emp.date_hired,
                                    employment_type_id: emp.employment_type.name.value,
                                    regularization_date: emp.regularization_date,
                                    course: emp.course,
                                    educational_institution: emp.educational_institution,
                                    year_graduated: emp.year_graduated.value,
                                    address_id: emp.address.id,
                                    current_address: emp.address.current_address,
                                    government_credential_id: emp.government_credential_id,
                                    phil_health_number: emp.government_credential.phil_health_number,
                                    hmdf_number: emp.government_credential.hmdf_number,
                                    sss_number: emp.government_credential.sss_number,
                                    tin_number: emp.government_credential.tin_number,
                                    person_to_contact_in_case_of_emergency: emp.person_to_contact_in_case_of_emergency,
                                    relationship: emp.relationship,
                                    contact_person_no: emp.contact_person_no
                                }
                            }).then(response => {
                                this.laddabtn.stop();
                                swal({
                                    title: 'Saved!',
                                    type: "success",
                                });
                                return response.data;
                            });
                        } else {

                            return false;
                        }
                    });
            },
        }
    }
</script>