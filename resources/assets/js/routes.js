import login from './components/login.vue'

/*Main Page group*/
import mainpage from './components/mainPage.vue'
import vpsMain from './components/dashboard/main.vue'
import vpsProfile from './components/vps/profile.vue'

/*HR group*/
import nteList from './components/hr/nte/'
import nteFormList from './components/hr/nte/nteform/'
import provisionList from './components/hr/nte/provision/'
import gravityList from './components/hr/nte/gravity/'
import ntecategory from './components/hr/nte/category/'
import nteoffense from './components/hr/nte/offense/'
import correctiveaction from './components/hr/nte/correctiveaction/'
import nteAdd from './components/hr/nte/add.vue'
import nteEdit from './components/hr/nte/edit.vue'

//payment manager
import paymentsearch from './components/paymentmanager/search.vue'
import paymentchanges from './components/paymentmanager/changes.vue'

// ticketing group
import ticketList from './components/ticketing/'

//actions survey component
import surveyList from './components/actions/survey'
import surveyEdit from './components/actions/survey/edit.vue'
import surveyAgent from './components/actions/survey/agent/agent.vue'
import surveyExam from './components/actions/survey/agent/agentSurvey.vue'

/*admin group*/
import payment from './components/admin/request_payment/'
import paymentForm from './components/admin/request_payment/form.vue'
import supplies from './components/admin/purchasing_supplies/'
import suppliesForm from './components/admin/purchasing_supplies/form.vue'

/*settings group*/
import acl from './components/settings/acl/'
import department from './components/settings/department/'
import designation from './components/settings/designation/'
import employeeList from './components/settings/user/'
import employeeEdit from './components/settings/user/editTabs.vue'
import costcenter from './components/settings/cost_center/'
import officelocation from './components/settings/office_location/'
import employmenttype from './components/settings/employment_type/'
import portfolio from './components/settings/portfolio/'
import states from './components/settings/state/'
import usersgroups from './components/settings/users_groups/'
import scriptTags from './components/dashboard/script_tags/'
import scriptEdit from './components/dashboard/script_tags/edit.vue'
import scriptAgent from './components/dashboard/script_tags/agent.vue'

/* TK group*/
import workWeek from './components/tk/workWeek.vue'
import shiftList from './components/tk/shift/'
import shiftActivitiesList from './components/tk/shift_activities/'
import schedulesList from './components/tk/schedules/'

/*loanapproval group*/
import { applicationForm, applications, duplicateCheck, loanMatrix } from './components/loanapproval/';
import badAba from './components/loanapproval/bad_aba/'
import adjFinanceFee from './components/loanapproval/adj_finance/'
import reAssign from './components/loanapproval/reassign/'
import corrections from './components/loanapproval/corrections/'
import dcList from './components/loanapproval/dc_info/'

/*QA group*/
import QaMain from './components/qa/main/dashboard.vue';
import QaForm from './components/qa/form/mainForm.vue';
import FormList from './components/qa/form/FormList.vue';
import AuditStatus from './components/qa/form/AuditStatus.vue';
import CoachingLogs from './components/qa/form/CoachingLogs.vue';
import Disputes from './components/qa/form/disputes.vue';
import Clarifications from  './components/qa/form/clarifications.vue';
import QaReports from './components/qa/reports/reports.vue';
import MonthlyScore from './components/qa/reports/monthlyScore.vue';
import ScoreSummary from './components/qa/reports/scoreSummary.vue';
import GenerateSummary from './components/qa/reports/generateSummary.vue';
import DetailedReport from './components/qa/reports/detailedReport.vue';
import StatusReport from './components/qa/reports/statusReport.vue';
import QaSettings from './components/qa/settings/settings.vue';
import Categories from './components/qa/settings/categories.vue';
import SubCategories from './components/qa/settings/subCategories.vue';
import Descriptions from './components/qa/settings/descriptions.vue';
import ImportEmployee from './components/qa/settings/importEmployee.vue';
import User from './components/qa/settings/user.vue';

// let acl_rules = vps.settings.acl_rules;
// let loan_approval = acl_rules.rules.loanapproval;
// console.log(acl_rules);
// console.log(acl_rules.rules.loanapproval)
/*
Add is_menu if you want to exclude the route from menu default true | if not set default include
* is_menu : exclude or include on menu | not specify will include
* label : Menu Name
* icon : Menu Icon
 */
export default [
    { path: '/login', component: login, is_menu: false, },

    { path: '/', redirect: '/home', label: 'Dashboard', icon:'fas fa-tachometer-alt' },
    { path: '/script',  component: mainpage, label: 'ARB', icon:'far fa-building',
        meta: {
            rules : 'script',
            global_menu : true,
        },
        children: [ 
            { path: '/script/agent', component: scriptAgent, label : 'Scripts',  icon:'fa fa-file-word'},
            { path: '/script/survey_agent', component: surveyAgent, label: 'Voting List', icon: 'fa fa-list-alt'},
            { path: '/script/survey/exam/:survey_id', component: surveyExam, is_menu:false, icon:'' },
        ]
    },
    // { path: '/action',  component: mainpage, label: 'Actions', icon:'fa fa-list-alt',
    //     meta: {
    //         rules : 'action',
    //         global_menu : true,
    //     },
    //     children: [
    //         { path: '/action/survey', component: surveyList, label : 'Survey',  icon:'fa fa-list-alt', meta: {rules: 'actionsurvey'} },
    //         { path: '/action/survey/edit/:survey_id', component: surveyEdit, is_menu:false, icon:'' },
    //         { path: '/action/agent', component: surveyAgent, label: 'Survey List', icon: 'fa fa-list-alt', meta: { rules: 'agentsurvey' } },
    //         { path: '/action/survey/exam/:survey_id', component: surveyExam, is_menu:false, icon:'' },
    //     ]
    // },
    { path: '/home', component: mainpage, meta: { breadcrumb: 'Home' }, is_menu: false, icon:'',
        children : [
            { path: '/home', component: vpsMain },
            { path: '/profile', component: vpsProfile, meta: { breadcrumb: 'Profile' }, },
    ]},
    //survey
    // { path: '/action',  component: mainpage, label: 'Actions', icon:'fa fa-list-alt',
    //     meta: {
    //         rules : 'action',
    //         global_menu : true,
    //     },
    //     children: [
            
    //     ]
    // },

    // payment manager
    { path: '/paymentmanager',  component: mainpage, label: 'LMS Payments', icon:'fa fa-database',
        meta: {
            rules : 'paymentmanager',
            global_menu : true,
        },
        children: [ 
            { path: '/paymentmanager/search', component: paymentsearch, label : 'Search',  icon:'fa fa-database', meta: {rules: 'search'} },
            { path: '/paymentmanager/changes', component: paymentchanges, label : 'Changes',  icon:'fa fa-database', meta: {rules: 'changes'} }
        ]
    },


    /*TK Group*/
    { path: '/tk', component: mainpage, label : 'Timekeeping', icon:'fas fa-clock',
        meta: {
             rules : 'tk',
             global_menu : false,
            },
        children : [
            { path: '/tk/workweek/', component: workWeek, label : 'Application List', icon:'fa fa-calendar',  meta: { breadcrumb: 'Work Week', rules : 'workweek', } },
            { path: '/tk/shift/', component: shiftList, label : 'Shift Activity', icon:'fa fa-list-ol', meta: { breadcrumb: 'Shift List' } },
            { path: '/tk/shiftactivities/', component: shiftActivitiesList, icon:'fa fa-list-alt', label : 'Shift List', meta: { breadcrumb: 'Shift Activities List' } },
            { path: '/tk/schedules/', component: schedulesList, label : 'Schedules', icon:'fa fa-list-ul', meta: { breadcrumb: 'Schedules' } },
        ]
    },

    // ticketing group
    { path: '/ticket', component: mainpage, label : 'Ticketing', icon:'fas fa-clock',
        meta: {
             rules : 'ticketing',
             global_menu : false,
            },
        children : [
            { path: '/ticketing', component: ticketList, label : 'Issue Ticket', icon:'fa fa-calendar',  meta: { breadcrumb: 'Tracking Issue', rules : 'tracking', } },
        ]
    },

    /*loanapproval group*/
    { path: '/loanapproval', component: mainpage, label : 'Loan Approval', icon:'fas fa-folder-open'
        , meta: {
            breadcrumb: 'Home',
            rules : 'loanapproval',
            global_menu : true,
        },
        children : [
            { path: '/loanapproval/applicationform', component: applicationForm, label : 'Applications Form', icon:'fab fa-wpforms',
                meta: {
                    breadcrumb: 'Application Form',
                    rules : 'application_form',
                },
            },
            { path: '/loanapproval/applications/', component: applications, label : 'Applications', icon:'fas fa-database',
                meta: {
                    breadcrumb: 'Applications',
                    rules : 'application_list',
                },
            },
            { path: '/loanapproval/duplicate_checker/', component: duplicateCheck, label: 'Duplicate Check', icon: 'far fa-copy',
                meta: {
                    breadcrumb: 'Duplicate Checker',
                    global_menu : true,

                },
            },
            { path: '/loanapproval/applications/:action/:id', component: applicationForm,  is_menu: false,},
            { path: '/loanapproval/dcinfo/', component: dcList, label: 'DC Info List', icon: 'fas fa-credit-card',
                meta: {
                        breadcrumb: 'DC Info List',
                            rules : 'dcinfo',
                    },
            },
            { path: '/loanapproval/badaba/', component: badAba, label: 'Bab ABA', icon: 'fas fa-certificate',
                meta: {
                        breadcrumb: 'BAD ABA List',
                            rules : 'badaba',
                    },
            },
            { path: '/loanapproval/adjustmentfinancefee/', component: adjFinanceFee, label: 'Adj Finance Fee', icon: 'fas fa-adjust',
                meta: {
                        breadcrumb: 'Adj Finance Fee List',
                            rules : 'adjustmentfinancefee',
                    },
            },
            // { path: '/loanapproval/reassignapp/', component: reAssign, label: 'Re-Assign App', icon: 'far fa-credit-card',
            //     meta: {
            //             breadcrumb: 'Re-Assign App',
            //                 rules : 'reassignapp',
            //         },
            // },
            { path: '/loanapproval/corrections/', component: corrections, label: 'Corrections', icon: 'far fa-credit-card',
                meta: {
                        breadcrumb: 'Corrections',
                            rules : 'corrections',
                    },
            },
            // { path: '/loanapproval/applicationForm', component: applicationForm, icon:'' },
        ]
    },

    /*HR Group*/
    { path: '/hr', component: mainpage, label : 'HR Department', icon:'fas fa-book',
        meta: {
            breadcrumb: 'HR',
            rules : 'hr',
            global_menu : false,
        },
        children : [
            { path: '/hr/ntecategory', component: ntecategory, label: 'NTE Categories', icon:'fa fa-address-book',
                meta: {
                    rules : 'ntecategory',
                },
            },
            { path: '/hr/ntegravity', component: gravityList, label: 'NTE Gravity\'s', icon:'fa fa-newspaper',
                meta: {
                    rules : 'gravity',
                },
            },
            { path: '/hr/nteprovision', component: provisionList, label: 'NTE Provision', icon:'fa fa-notes-medical',
                meta: {
                    rules : 'provision',
                },
            },
            { path: '/hr/correctiveaction', component: correctiveaction, label: 'Corrective Action', icon:'fa fa-edit',
                meta: {
                    rules : 'correctiveaction',
                },
            },
            { path: '/hr/offense', component: nteoffense, label: 'NTE Offense', icon:'fa fa-file-code',
                meta: {
                    rules : 'nteoffense',
                },
            },
            { path: '/hr/nteforms', component: nteFormList, label: 'NTE Forms', icon:'fa fa-paragraph',
                meta: {
                    rules : 'formlist',
                },
            },
            { path: '/hr/nte', component: nteList, label: 'NTE Issuance', icon:'fa fa-address-book',
                meta: {
                    rules : 'nteform',
                },
            },
            { path: '/hr/nte/form/:nte_id', component: nteAdd, is_menu:false, icon:'' },
            { path: '/hr/nte/edit/:nte_id', component: nteEdit, is_menu:false, icon:'' },
        ]
    },

    /*admin group*/
    { path: '/admin', component: mainpage, label : 'Admin Department', icon:'fas fa-briefcase', 
        meta: { 
            breadcrumb: 'Admin',
            rules : 'admin' ,
            global_menu : false,
        },
        children : [
            { path: '/admin/payment', icon:'fa fa-money-bill-alt', component: payment, label: 'Request Payment', 
                meta: {
                    rules : 'requestpayment',
                },
            },
            { path: '/admin/paymentform', icon:'fa fa-money-bill-alt', component: paymentForm, label: 'Payment Form', 
                meta: {
                    rules : 'requestpaymentcreate',
                },
            },
            { path: '/admin/supplies', icon:'fa fa-dollar-sign', component: supplies, label: 'Purchasing Supplies',
                meta: {
                    rules : 'purchasingsupplies',
                },
            },
            { path: '/admin/suppliesform', icon:'fa fa-dollar-sign', component: suppliesForm, label: 'Purchasing Form',
                meta: {
                    rules : 'purchasingsuppliescreate',
                },
            },
        ]
    },

    /*QA Group*/
    { path: '/qa', component: mainpage, label : 'Quality Assurance', meta: { breadcrumb: 'Home' }, icon:'fas fa-check-square',
        meta: {
            breadcrumb: 'Quality Assurance',
            rules : 'qa',
            global_menu : false,
        },
        children: [
            { path: '/qa/dashboard', component: QaMain, label: 'Main Page', icon:'fa fa-th-large',
                meta: {
                    breadcrumb: 'Quality Assurance Dashboard',
                    rules : 'dashboard',
                },
            },
            { path: '/form', name:'form', component: QaForm, label: 'QA Form', icon: 'fa fa-edit',
                meta: {
                    breadcrumb: 'Quality Assurance Form',
                    rules : 'form',
                },
                children: [
                    { path: '/qa/form/list', component: FormList, label: 'Form List', icon:'',
                        meta: {
                            rules : 'formlist',
                        },
                    },
                    { path: '/qa/form/search', component: FormList, is_menu:false, icon:'', },
                    { path: '/qa/form/view/:id', component: FormList, is_menu:false, icon:'', },
                    { path: '/qa/form/audit-status', component: AuditStatus, label: 'Audit Status', icon:'',
                        meta: {
                            rules : 'auditstatus',
                        },
                    },
                    { path: '/qa/form/coaching-logs', component: CoachingLogs, label: 'Coaching Logs', icon:'',
                        meta: {
                            rules : 'coachinglogs',
                        },
                    },
                    { path: '/qa/form/disputes', component: Disputes, label: 'Disputes', icon:'',
                        meta: {
                            rules : 'disputes',
                        },
                    },
                    { path: '/qa/form/clarifications', component: Clarifications, label: 'Clarifications', icon:'',
                        meta: {
                            rules : 'clarification',
                        },
                    },
                ]
            },
            { path: '/reports', component: QaReports, label: 'Reports', icon:'fa fa-tasks',
                meta: {
                    breadcrumb: 'Quality Assurance Reports',
                    rules : 'qareports',
                },
                children: [
                    { path: '/qa/reports/monthly-score', component: MonthlyScore, label: 'Monthly Score', icon:'',
                        meta: {
                            rules : 'monthlyscore',
                        },
                    },
                    { path: '/qa/reports/score-summary', component: ScoreSummary, label: 'Score Summary', icon:'',
                        meta: {
                            rules : 'scoresummary',
                        },
                    },
                    { path: '/qa/reports/generate-summary', component: GenerateSummary, label: 'Generate Summary', icon:'',
                        meta: {
                            rules : 'generatesummary',
                        },
                    },
                    { path: '/qa/reports/detailed-report', component: DetailedReport, label: 'Detailed Report', icon:'',
                        meta: {
                            rules : 'detailedreport',
                        },
                    },
                    { path: '/qa/reports/status-report', component: StatusReport, label: 'Status Report', icon:'',
                        meta: {
                            rules : 'statusreport',
                        },
                    },
                ]
            },
            { path: '/settings', component: QaSettings, label: 'Settings', icon:'fa fa-cogs',
                meta: {
                    breadcrumb: 'Quality Assurance Reports',
                    rules : 'qasettings',
                },
                children: [
                    { path: '/qa/settings/categories', component: Categories, label: 'Categories', icon:'',
                        meta: {
                            rules : 'categories',
                        },
                    },
                    { path: '/qa/settings/sub-categories', component: SubCategories, label: 'Sub-categories', icon:'',
                        meta: {
                            rules : 'subcategories',
                        },
                    },
                    { path: '/qa/settings/descriptions', component: Descriptions, label: 'Descriptions', icon:'',
                        meta: {
                            rules : 'descriptions',
                        },
                    },
                    { path: '/qa/settings/import-employee', component: ImportEmployee, label: 'Import Employee', icon:'',
                        meta: {
                            rules : 'importemployee',
                        },
                    },
                    { path: '/qa/settings/user', component: User, label: 'Employee Records', icon:'',
                        meta: {
                            rules : 'user',
                        },
                    },
                ]
            },
        ]
    },

    /*settings group*/
    { path: '/settings', component: mainpage, label : 'Settings', meta: { breadcrumb: 'Home' }, icon:'fas fa-cogs',
                meta: {
                    rules : 'settings',
                    global_menu : false,
                },
        children : [
            { path: '/settings/acl', component: acl, label: 'ACL Rules', icon:'fa fa-object-group',
                meta: {
                    rules : 'aclrules',
                },
            },
            { path: '/settings/usersgroups', component: usersgroups, label: 'Users Groups', icon:'fa fa-users',
                meta: {
                    rules : 'usersgroups',
                },
            },
            { path: '/settings/department', component: department, label: 'Department', icon:'fa fa-home',
                meta: {
                    rules : 'department',
                },
            },
            { path: '/settings/designation', component: designation, label: 'Designation', icon:'fa fa-bus',
                meta: {
                    rules : 'designation',
                },
            },
            { path: '/settings/costcenter', component: costcenter, label: 'Cost Center', icon:'fa fa-car',
                meta: {
                    rules : 'costcenter',
                },
            },
            { path: '/settings/officelocation', component: officelocation, label: 'Office Location', icon:'fa fa-map',
                meta: {
                    rules : 'officelocation',
                },
            },
            { path: '/settings/employment', component: employmenttype, label: 'Employment Type', icon:'fa fa-user-circle',
                meta: {
                    rules : 'employmenttype',
                },
            },
            { path: '/settings/employee', component: employeeList, label: 'Employee', icon:'fa fa-user',
                meta: {
                    rules : 'employees',
                }
             },
            { path: '/settings/employee/:employee_id/edit', component: employeeEdit, name: 'employee-edit', is_menu:false, icon:'', },
            { path: '/settings/portfolio', component: portfolio, label: 'Portfolio', icon:'fa fa-briefcase-medical',
                meta: {
                    rules : 'portfolios',
                },
            },
            { path: '/settings/states', component: states, label: 'States', icon:'fa fa-flag',
                meta: {
                    rules : 'states',
                },
            },
            { path: '/settings/script', component: scriptTags, label: 'Scripts Tags', icon:'fa fa-file-code',
                meta: {
                    rules : 'tags',
                },
            },
            { path: '/settings/survey', component: surveyList, label : 'Survey',  icon:'fa fa-list-alt', meta: {rules: 'actionsurvey'} },
            { path: '/settings/survey/edit/:survey_id', component: surveyEdit, is_menu:false, icon:'' },
            { path: '/settings/script/:script_id', component: scriptEdit, is_menu:false, icon:'' },
        ]
    },
]