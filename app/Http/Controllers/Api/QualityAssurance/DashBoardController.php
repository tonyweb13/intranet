<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\BusinessLayer\AuditCounts;
use App\BusinessLayer\Clarifications;
use App\BusinessLayer\Disputes;
use App\BusinessLayer\ProcessForm;
use App\BusinessLayer\Sessions;
use App\BusinessLayer\TopDrivers;
use App\BusinessLayer\Users;
use App\Models\CsrAuditResult;
use App\Models\CsrForm;
use App\Models\Description;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


class DashBoardController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $audit_counts = new AuditCounts();
        $audit_disputes = new Disputes();
        $process_form = new ProcessForm();
        $audit_clarification = new Clarifications();
        $user = new Users();
        if ($request->input('month')) {
            session(['month' => $request->input('month')]);
        } else {
            if (!$request->session()->has('month')) {
                session(['month' => date('m')]);
            }
        }
        $month = $request->session()->get('month');
        $user_info = $user->usersInformation();
        if (!$user_info) {
            return redirect()->to('/login')->withErrors(['Invalid Username/Password', 'message']);
        }

        $role = $user->role($user_info->emp_no);
        $data['role'] = $role;
        $data['user'] = Auth::user();
        $data['months'] = $this->monthArray();
        $data['selected'] = $request->input('supervisor_id');
        $data['selected_month'] = $month;
        $data['title'] = 'Dashboard';
        $data['users_list'] = $user->usersList();
        $data['employee_info'] = $user_info;
        $data['allowed'] = $user->isAllowed($role);
        $data['unresolved_disputes'] = $audit_disputes->retrieveUnresolvedDisputes($month, $role);
        $data['unresolved_clarification'] = $audit_clarification->retrieveUnresolvedClarifications($month, $role);
        $employee_id = $user_info->emp_no;

        if ($role == 'admin' || $role == 'manager') {
            $data['form_total_count'] = $audit_counts->auditTotalCounts($role, $month);
            $data['form_ongoing_count'] = $audit_counts->auditOngoingCounts($role, $month);
            $data['form_done_count'] = $audit_counts->auditDoneTotalCounts($role, $month);
            $data['form_none_compliance_count'] = $audit_counts->auditNoneComplianceCounts($role, $month);
            $data['scoreSum'] = $audit_counts->auditScoreAverage($role, $month);
            $data['disputes'] = $audit_disputes->disputesAll($role, $month)->toArray();
            $data['clarification'] = $audit_clarification->clarificationsAll($role, $month, $request->input('supervisor_id'));
        } elseif ($role == 'operation') {
            $data['supervisors'] = $process_form->retrieveSupervisors('')->pluck('emp_no')->toArray();
            $data['form_total_count'] = $audit_counts->auditTotalCounts($role, $month);
            $data['form_ongoing_count'] = $audit_counts->auditOngoingCounts($role, $month);
            $data['form_done_count'] = $audit_counts->auditDoneTotalCounts($role, $month);
            $data['form_none_compliance_count'] = $audit_counts->auditNoneComplianceCounts($role, $month);
            $data['scoreSum'] = $audit_counts->auditScoreAverage($role, $month);
            $data['disputes'] = $audit_disputes->disputesAll($role, $month)->toArray();
            $data['clarification'] = $audit_clarification->clarificationsAll($role, $month, $request->input('supervisor_id'));
        } elseif ($role == 'deputy') {
            $data['supervisors'] = $process_form->retrieveSupervisors($user_info->emp_no)->pluck('emp_no')->toArray();
            $data['form_total_count'] = $audit_counts->auditTotalCounts($role, $month);
            $data['form_ongoing_count'] = $audit_counts->auditOngoingCounts($role, $month);
            $data['form_done_count'] = $audit_counts->auditDoneTotalCounts($role, $month);
            $data['form_none_compliance_count'] = $audit_counts->auditNoneComplianceCounts($role, $month);
            $data['scoreSum'] = $audit_counts->auditScoreAverage($role, $month);
            $data['disputes'] = $audit_disputes->disputesAll($role, $month)->toArray();
            $data['clarification'] = $audit_clarification->clarificationsAll($role, $month, $request->input('supervisor_id'));
        } elseif (Auth::user()->roles_name === 'underwriters') {
            $data['form_total_count'] = $audit_counts->auditUnderwritersTotalCounts($month, $employee_id);
            $data['form_ongoing_count'] = $audit_counts->auditUnderwritersOngoingTotalCounts($month, $employee_id);
            $data['form_done_count'] = $audit_counts->auditUnderwritersDoneTotalCounts($month, $employee_id);
            $data['form_none_compliance_count'] = $audit_counts->auditUnderwritersNoneComplianceCounts($month, $employee_id);
            $data['scoreSum'] = $audit_counts->auditUnderwritersScoreAverage($month, $employee_id);
            $data['disputes'] = $audit_disputes->disputesUnderwriters($month, $employee_id)->toArray();
            $data['clarification'] = $audit_clarification->clarificationsUnderwriters($month, $employee_id);
        } elseif (Auth::user()->roles_name === 'supervisors') {
            $data['form_total_count'] = $audit_counts->auditSupervisorsTotalCounts($month, $employee_id);
            $data['form_ongoing_count'] = $audit_counts->auditSupervisorsOngoingTotalCounts($month, $employee_id);
            $data['form_done_count'] = $audit_counts->auditSupervisorsDoneTotalCounts($month, $employee_id);
            $data['form_none_compliance_count'] = $audit_counts->auditSupervisorsNoneComplianceCounts($month, $employee_id);
            $data['scoreSum'] = $audit_counts->auditSupervisorsScoreAverage($month, $employee_id);
            $data['disputes'] = $audit_disputes->disputesSupervisors($month, $employee_id)->toArray();
            $data['clarification'] = $audit_clarification->clarificationsSupervisors($month, $employee_id);
        } else {
            $data['form_total_count'] = $audit_counts->auditAgentTotalCounts($month, $employee_id);
            $data['form_ongoing_count'] = $audit_counts->auditAgentOngoingTotalCounts($month, $employee_id);
            $data['form_done_count'] = $audit_counts->auditAgentDoneTotalCounts($month, $employee_id);
            $data['form_none_compliance_count'] = $audit_counts->auditAgentNoneComplianceCounts($month, $employee_id);
            $data['scoreSum'] = $audit_counts->auditAgentScoreAverage($month, $employee_id);
            $data['disputes'] = $audit_disputes->disputesAgent($month, $employee_id)->toArray();
            $data['clarification'] = $audit_clarification->clarificationsAgent($month, $employee_id);
        }

        return view('main', $data);
    }

    public function topDriversScores($month = '')
    {
        $top_drivers = new TopDrivers();
        $user = new Users();
        $user_info = $user->usersInformation();
        $role = $user->role($user_info->emp_no);

        $date = ($month) ? $month : date('m');
        if ($role === 'admin' || $role === 'manager') {
            $employee_id = '';
        } else {
            $employee_id = $user_info->emp_no;
        }

        //originator
        $originator_data = $top_drivers->retrieveOriginatorResult($role, $date, $employee_id);
        //collection
        $collection_data = $top_drivers->retrieveCollectionResult($role, $date, $employee_id);

        $data['originator_operation'] = $originator_data['operation'];
        $data['originator_compliance'] = $originator_data['compliance'];
        $data['collection_operation'] = $collection_data['operation'];
        $data['collection_compliance'] = $collection_data['compliance'];

        return $data;
    }

    public function monthArray()
    {
        return array(
            '01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December'
        );
    }

    public function indexMain()
    {
        $data = [];
        $data['user'] = Auth::user();

        $user = User::with('role')
            ->where('l_name', Auth::user()->lname)
            ->where('f_name', Auth::user()->fname)->first()->toArray();
        $data['title'] = 'Dashboard';
        $role = Role::where('user_id', $user['emp_no'])->first();
        $data['users_list'] = $this->usersList();

        $data['allowed'] = false;
        if ($role['role'] == 'admin' || Auth::user()->roles_name === 'underwriters') {
            $data['allowed'] = true;
        }

        $id = $user['emp_no'];
        if ($role['role'] == 'admin' || $role['role'] == 'manager' || Auth::user()->roles_name === 'admin') {
            $data['form_total_count'] = CsrForm::all()->count();
            $data['form_ongoing_count'] = CsrForm::where('status', false)->get()->count();
            $data['form_done_count'] = CsrForm::where('status', true)->get()->count();
            $data['form_none_compliance_count'] = CsrForm::whereHas('csrAudit', function ($query) {
                $query->where('is_compliance', false);
            })->get()->count();
            $data['scoreSum'] = CsrForm::get()->sum('score');

            $data['disputes'] = CsrAuditResult::whereHas('dispute')
                ->with('dispute.feedback', 'csrAudit.csrForm', 'description')
                ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                    $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                }])->get()->groupBy('csr_audit_id')->toArray();

            $data['clarification'] = CsrAuditResult::whereHas('clarification')
                ->with('clarification.clarificationFeedback', 'csrAudit.csrForm', 'description')
                ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                    $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                }])->get()->groupBy('csr_audit_id')->toArray();

            if (strpos($user['position'],'Collection' !== false)) {
                $scores = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 2]);
                })->where('sub_category_id', '!=', 9)
                    ->get()->toArray();

                $compliance = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 2]);
                })->where('sub_category_id', '=', 9)
                    ->get()->toArray();
                $data['compliance'] = $this->countMainScores($compliance);
                $data['scores'] = $this->countMainScores($scores);
            } else {
                $scores = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 1]);
                })->where('sub_category_id', '!=', 4)
                    ->get()->toArray();
                $compliance = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 1]);
                })->where('sub_category_id', '=', 4)
                    ->get()->toArray();
                $data['compliance'] = $this->countMainScores($compliance);
                $data['scores'] = $this->countMainScores($scores);
            }
        } elseif (Auth::user()->roles_name === 'underwriters') {
            $data['form_total_count'] = CsrForm::where(['created_by'=>$id])->count();
            $data['form_ongoing_count'] = CsrForm::where(['created_by'=>$id])->where('status', false)->get()->count();
            $data['form_done_count'] = CsrForm::where(['created_by'=>$id])->where('status', true)->get()->count();
            $data['form_pass_count'] = CsrForm::where(['created_by'=>$id])->where('is_compliance', true)
                ->get()->count();
            $data['form_none_compliance_count'] = CsrForm::whereHas('csrAudit', function ($query) {
                $query->where('is_compliance', false);
            })->where(['created_by'=>$id])->get()->count();
            $data['scoreSum'] = CsrForm::where(['created_by'=>$id])->get()->sum('score');
            $data['disputes'] = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($user) {
                $query->where('created_by', $user['emp_no']);
            })->whereHas('dispute')
                ->with('dispute.feedback', 'csrAudit.csrForm', 'description')
                ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                    $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                }])->get()->groupBy('csr_audit_id')->toArray();
            $data['clarification'] = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($user) {
                $query->where('created_by', $user['emp_no']);
            })->whereHas('clarification')
                ->with('clarification.clarificationFeedback', 'csrAudit.csrForm', 'description')
                ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                    $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                }])->get()->groupBy('csr_audit_id')->toArray();

            if (strpos($user['position'],'Collection' !== false)) {
                $scores = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 2]);
                })->where('sub_category_id', '!=', 9)
                    ->get()->toArray();
                $compliance = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 2]);
                })->where('sub_category_id', '=', 9)
                    ->get()->toArray();
                $data['compliance'] = $this->countMainScores($compliance);
                $data['scores'] = $this->countMainScores($scores);
            } else {
                $scores = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 1]);
                })->where('sub_category_id', '!=', 4)
                    ->get()->toArray();
                $compliance = Description::whereHas('subCategory.category', function ($query) {
                    $query->where(['category_type'=> 1]);
                })->where('sub_category_id', '=', 4)
                    ->get()->toArray();
                $data['compliance'] = $this->countMainScores($compliance);
                $data['scores'] = $this->countMainScores($scores);
            }
        } else {
            if (Auth::user()->roles_name === 'supervisors') {
                $data['form_total_count'] = CsrForm::whereHas('user', function ($query) use ($id) {
                    $query->where(['supervisor_id'=>$id]);
                })->count();
                $data['form_ongoing_count'] = CsrForm::whereHas('user', function ($query) use ($id) {
                    $query->where(['supervisor_id'=>$id]);
                })->where('status', false)->get()->count();
                $data['form_done_count'] = CsrForm::whereHas('user', function ($query) use ($id) {
                    $query->where(['supervisor_id'=>$id]);
                })->where('status', true)->get()->count();
                $data['form_pass_count'] = CsrForm::whereHas('user', function ($query) use ($id) {
                    $query->where(['supervisor_id'=>$id]);
                })->where('is_compliance', true)
                    ->get()->count();
                $data['form_none_compliance_count'] = CsrForm::whereHas('user', function ($query) use ($id) {
                    $query->where(['supervisor_id'=>$id]);
                })->whereHas('csrAudit', function ($query) {
                    $query->where('is_compliance', false);
                })->get()->count();
                $data['scoreSum'] = CsrForm::whereHas('user', function ($query) use ($id) {
                    $query->where(['supervisor_id'=>$id]);
                })->get()->sum('score');
                $data['disputes'] = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($id) {
                    $query->whereHas('user', function ($query) use ($id) {
                        $query->where('supervisor_id', $id);
                    });
                })->whereHas('dispute')
                    ->with('dispute.feedback', 'csrAudit.csrForm', 'description')
                    ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                        $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                    }])->get()->groupBy('csr_audit_id')->toArray();

                $data['clarification'] = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($id) {
                    $query->whereHas('user', function ($query) use ($id) {
                        $query->where('supervisor_id', $id);
                    });
                })->whereHas('clarification')
                    ->with('clarification.clarificationFeedback', 'csrAudit.csrForm', 'description')
                    ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                        $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                    }])->get()->groupBy('csr_audit_id')->toArray();

                if (strpos($user['position'],'Collection' !== false)) {
                    $scores = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 2]);
                    })->where('sub_category_id', '!=', 9)
                        ->get()->toArray();
                    $compliance = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 2]);
                    })->where('sub_category_id', '=', 9)
                        ->get()->toArray();
                    $data['compliance'] = $this->countMainScores($compliance);
                    $data['scores'] = $this->countMainScores($scores);
                } else {
                    $scores = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 1]);
                    })->where('sub_category_id', '!=', 4)
                        ->get()->toArray();
                    $compliance = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 1]);
                    })->where('sub_category_id', '=', 4)
                        ->get()->toArray();
                    $data['compliance'] = $this->countMainScores($compliance);
                    $data['scores'] = $this->countMainScores($scores);
                }
            } else {
                $data['form_total_count'] = CsrForm::where(['employee_id'=>$id])->count();
                $data['form_ongoing_count'] = CsrForm::where(['employee_id'=>$id])->where('status', false)->get()->count();
                $data['form_done_count'] = CsrForm::where(['employee_id'=>$id])->where('status', true)->get()->count();
                $data['form_pass_count'] = CsrForm::where(['employee_id'=>$id])->where('is_compliance', true)
                    ->get()->count();
                $data['form_none_compliance_count'] = CsrForm::whereHas('csrAudit', function ($query) {
                    $query->where('is_compliance', false);
                })->where(['employee_id'=>$id])->get()->count();
                $data['scoreSum'] = CsrForm::where(['employee_id'=>$id])->get()->sum('score');

                $data['disputes'] = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($user) {
                    $query->where('employee_id', $user['emp_no']);
                })->whereHas('dispute')
                    ->with('dispute.feedback', 'csrAudit.csrForm', 'description')
                    ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                        $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                    }])->get()->groupBy('csr_audit_id')->toArray();
                $data['clarification'] = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($user) {
                    $query->where('employee_id', $user['emp_no']);
                })->whereHas('clarification')
                    ->with('clarification.clarificationFeedback', 'csrAudit.csrForm', 'description')
                    ->with(['csrAudit.csrForm.user'=> function ($query) use ($user){
                        $query->select(DB::raw("CONCAT(l_name, ', ', f_name) AS display_name"), 'emp_no');
                    }])->get()->groupBy('csr_audit_id')->toArray();

                if (strpos($user['position'],'Collection' !== false)) {
                    $scores = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 2]);
                    })->where('sub_category_id', '!=', 9)
                        ->get()->toArray();
                    $compliance = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 2]);
                    })->where('sub_category_id', '=', 9)
                        ->get()->toArray();
                    $data['compliance'] = $this->countOriginatorScores($compliance);
                    $data['scores'] = $this->countOriginatorScores($scores);
                } else {
                    $scores = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 1]);
                    })->where('sub_category_id', '!=', 4)
                        ->get()->toArray();
                    $compliance = Description::whereHas('subCategory.category', function ($query) {
                        $query->where(['category_type'=> 1]);
                    })->where('sub_category_id', '=', 4)
                        ->get()->toArray();
                    $data['compliance'] = $this->countMainScores($compliance);
                    $data['scores'] = $this->countMainScores($scores);
                }
            }
        }

        $data['employee_info'] = $user;

        $data['users_list'] = $this->usersList();

        return view('main', $data);
    }

    public function countMainScores($descriptions)
    {
        $results = [];
        $user = User::with('role')
            ->where('l_name', Auth::user()->lname)
            ->where('f_name', Auth::user()->fname)->first()->toArray();
        $data['title'] = 'Dashboard';
        $role = Role::where('user_id', $user['emp_no'])->first();
        $id = $user['emp_no'];

        foreach ($descriptions as $key => $description) {
            $data = [];
            if ($role['role'] == 'admin' || $role['role'] == 'manager' || Auth::user()->roles_name === 'admin') {
                $result = CsrAuditResult::whereHas('csrAudit.csrForm')
                    ->where('descriptions_id', $description['id'])
                    ->with('csrAudit.csrForm')
                    ->where('result', '0')->get()->toArray();
            } elseif (Auth::user()->roles_name === 'underwriters') {
                $result = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($id) {
                    $query->where(['created_by' => $id]);
                })->where('descriptions_id', $description['id'])
                    ->with('csrAudit.csrForm')
                    ->where('result', '0')->get()->toArray();
            } else {
                if (Auth::user()->roles_name === 'supervisors') {
                    $result = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($id) {
                        $query->where(['supervisor_id' => $id]);
                    })->where('descriptions_id', $description['id'])
                        ->with('csrAudit.csrForm')
                        ->where('result', '0')->get()->toArray();
                } elseif (Auth::user()->roles_name === 'underwriters') {
                    $result = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($id) {
                        $query->where(['created_by' => $id]);
                    })->where('descriptions_id', $description['id'])
                        ->with('csrAudit.csrForm')
                        ->where('result', '0')->get()->toArray();
                } else {
                    $result = CsrAuditResult::whereHas('csrAudit.csrForm', function ($query) use ($id) {
                        $query->where(['employee_id' => $id]);
                    })->where('descriptions_id', $description['id'])
                        ->with('csrAudit.csrForm')
                        ->where('result', '0')->get()->toArray();
                }
            }
            $data['count'] = count($result);
            $data['description'] = $description['name'];
            if (count($result) > 0) {
                array_push($results, $data);
            }
        }

        $results = array_values(array_sort($results, function ($value) {
            return $value['count'];
        }));

        $sorted = array_reverse($results);

        return $sorted;
    }

}