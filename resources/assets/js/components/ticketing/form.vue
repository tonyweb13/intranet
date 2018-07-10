<template>
    <div class="panel-body">
        <form @submit.prevent="createTicket">
        <div class="col-lg-4">
                <form-group label="Department To ">
                    <div class="asterisk_label">*</div>
                    <vSelect name="department"
                            v-model="ticket.department"
                            :options="departmentType"
                            label="text"
                            placeholder="Department To: "
                    />
                    <div class="pull-right">
                        <i v-show="errors.has('Department To')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('Department To')" class="help is-danger">{{ errors.first('Department To') }}</span>
                </form-group>
                <form-group label="Date From ">
                    <div class="asterisk_label">*</div>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="datefrom" class="form-control input-sm" name="date_from" type="text" placeholder="Date From"
                            v-model="ticket.date_from" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Date from') }" >
                        <div class="pull-right">
                            <i v-show="errors.has('Date from')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                        <span v-show="errors.has('Date from')" class="help is-danger">{{ errors.first('Date from') }}</span>
                    </div>
                </form-group>
                <form-group label="Date To ">
                    <div class="asterisk_label">*</div>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input class="form-control input-sm" id ="dateto" name="date_to" type="text" placeholder="Date To"
                            v-model="ticket.date_to" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Date to') }" >
                        <div class="pull-right">
                            <i v-show="errors.has('Date to')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                        <span v-show="errors.has('Date to')" class="help is-danger">{{ errors.first('Date to') }}</span>
                    </div>
                </form-group>
                <form-group label="Description">
                    <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="ticket.description" />
                </form-group>
                <form-group label="Priority">
                    <div class="asterisk_label">*</div>
                    <vSelect name="priority"
                            v-model="ticket.priority"
                            :options="priorityType"
                            label="text"
                            placeholder="Priority"
                    />
                    <div class="pull-right">
                        <i v-show="errors.has('Priority')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('Priority')" class="help is-danger">{{ errors.first('Priority') }}</span>
                </form-group>
        </div>
        <div class="col-lg-8">
            <form-group label="Issue">
                <div class="asterisk_label">*</div>
                <vue-editor v-model="ticket.issue" useCustomImageHandler @imageAdded="handleImageAdded"/>
            </form-group>
            <save-button :disabled='!isComplete' />
        </div>
        </form>
    </div>
</template>
<script>
     export default {
        data: function () {
            return {
                departmentType: [],
                ticket: {
                    department: '',
                    date_from: '',
                    date_to: '',
                    description:'',
                    priority: '',
                    issue: '',
                },
                priorityType: [
                    { text: 'High', value: 2 },
                    { text: 'Medium', value: 1 },
                    { text: 'Low', value: 0 },
                ]
            }
        },
        computed: {
           isComplete () {
                return this.ticket.department && this.ticket.priority && this.ticket.issue;
            }, 
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
            $("#dateto").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                }
            ).on(
                "changeDate", () => {
                    this.ticket.date_to = $("#dateto").val();
                }
            );
            $("#datefrom").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                }
            ).on(
                "changeDate", () => {
                    this.ticket.date_from = $("#datefrom").val();
                }
            );
        },
        created() {
            this.getDepartment();
        },
        methods: {
            getDepartment () {
                this.$constants.Settings_API.get('/department/dropdown')
                .then(response => {
                    this.departmentType = response.data;
                })
            },           
            createTicket: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let ticket = this.ticket;
                        let getAxios = '';
                        
                        getAxios = this.$constants.TICKET_API.get("/ticket/create", {
                                params: {
                                    department_to: ticket.department.value,
                                    date_from: ticket.date_from,
                                    date_to: ticket.date_to,
                                    description: ticket.description,
                                    priority: ticket.priority.value,
                                    issue: ticket.issue,
                                }
                            });

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('getTickets');
                            this.ticket.department = null;
                            this.ticket.date_from = null;
                            this.ticket.date_to = null;
                            this.ticket.description = null;
                            this.ticket.priority = null;
                            this.ticket.issue = null;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                            //this.$bus.$emit('updateList');
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
                });
            },
            handleImageAdded: function (file, Editor, cursorLocation, resetUploader) {
                let ticket = this.ticket;
                var formData = new FormData();
                formData.append('image', file);

                this.$constants.TICKET_API.post("/ticket/upload", formData)
                .then((result) => {
                    let url = result.data;
                    Editor.insertEmbed(cursorLocation, 'image', url);
                    resetUploader();
                })
                .catch((err) => {
                    console.log(err);
                })

            }
        }
    }
</script>