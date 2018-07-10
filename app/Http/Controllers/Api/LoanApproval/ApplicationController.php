<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\Application;
use App\Models\LoanApproval\ApplicationProcess;
use Illuminate\Http\Request;
use App\Http\Requests\ApplicationValidate;
use App\Models\User;
use App\Models\Vps\ {
    Users,
    UsersGroups
};

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApplicationController extends Controller
{

    protected $text_status;

    public function index()
    {
        $application = Application::all();
        return response()->json($application);
    }

    public function create()
    {
        return redirect('api/loanapproval/application');
    }

    public function store(ApplicationValidate $request)
    {
        $application = new Application;
        $application->loan_no = $request->loan_id;
        $application->portfolio = $request->portfolio;
        $application->pay_frequency = $request->pay_frequency;
        $application->first_name = $request->first_name;
        $application->last_name = $request->last_name;
        $application->email = $request->email;
        $application->ssn = $request->ssn_complete;
        $application->state = $request->state;
        $application->request_code = $request->dl_id;
        $application->new_or_returning = $request->new_ret;
        $application->ending_balance = $request->ebd;
        $application->voe = $request->voe_ret;
        $application->vob_session_id = $request->vob_session_id;
        $application->num_of_open_of_loans = $request->num_of_open_of_loans;
        $application->open_loan_amount = $request->open_loan_amount;
        $application->num_of_paid_of_loans = $request->num_of_paid_of_loans;
        $application->is_exception = $request->is_exception;
        $application->negative_balance = $request->negative_balance;
        $application->monthly_income = $request->monthly_income;
        $application->approved_loan_amount = $request->approved_loan_amount;
        $application->originator = Auth::user()->id;

        $application->vob = json_encode($request->view_data, JSON_FORCE_OBJECT);
        $application->status = 1; // Queue

        if (!$application->save() )
        {
            $return['message'] = 'Error Application not sent for approval';
            return $return;
        }

        $return['message'] = 'Application Successfully sent for approval';

        return $return;
    }

    public function update(Request $request, $id)
    {
//      echo $request->data;
//      var_dump(json_decode($request->data));

        $application = Application::find($id);

        $application->loan_no = $request->loan_id;
        $application->portfolio = $request->portfolio;
        $application->pay_frequency = $request->pay_frequency;
        $application->first_name = $request->first_name;
        $application->last_name = $request->last_name;
        $application->email = $request->email;
        $application->ssn = $request->ssn_complete;
        $application->state = $request->state;
        $application->request_code = $request->dl_id;
        $application->new_or_returning = $request->new_ret;
        $application->ending_balance = $request->ebd;
        $application->voe = $request->voe_ret;
        $application->vob_session_id = $request->vob_session_id;
        $application->num_of_open_of_loans = $request->num_of_open_of_loans;
        $application->open_loan_amount = $request->open_loan_amount;
        $application->num_of_paid_of_loans = $request->num_of_paid_of_loans;
        $application->is_exception = $request->is_exception;
        $application->negative_balance = $request->negative_balance;
        $application->monthly_income = $request->monthly_income;
        $application->approved_loan_amount = $request->approved_loan_amount;
        $application->vob = json_encode($request->vob, JSON_FORCE_OBJECT);

        if(isset($request->status)) {
            $application->status = $request->status;
        }

        if(!$application->isDirty()) {
            $return['no_update'] = '';
            $return['msg'] = 'Nothing to Update';
            return $return;
        }

        if (!$application->save())
        {
            $return['msg'] = 'Unable to Update';
            return $return;
        }

        $return['msg'] = 'Application Successfully Updated!';

        return $return;
    }

    public function reApproved(Request $request)
    {
        $response['msg'] = '';
        $response['errors'] = 0;

        try {
            /* Update Application Status to Pending */
            $apps= Application::find($request->id);
            $apps->status         = 6;
            $apps->updated_at     = Carbon::now();
            $apps->unsetEventDispatcher();
            $apps->update();

            ApplicationProcess::addApplicationProcess('reapproved', $request->id, 6, Auth::id(), 'Application sent for Re-Approval');

            $response['msg'] = 'Application successfully return for approval';

        } catch (Exception $e) {
            $response['msg'] = 'Caught exception: '. $e->getMessage();
            $response['errors'] = 1;
        }

        return [
            'msg' => $response['msg'],
            'error' => $response['errors']
        ];
    }

    public function approved(Request $request)
    {
        $response['msg'] = '';
        $response['errors'] = 0;

        try {
            /* Update Application Status to Pending */
            $apps= Application::find($request->id);
            $apps->status         = 3;
            $apps->updated_at     = Carbon::now();
            $apps->unsetEventDispatcher();
            $apps->update();

            ApplicationProcess::addApplicationProcess('approved', $request->id, 3, Auth::id(), 'Application Approved');

            $response['msg'] = 'Application successfully approved';

        } catch (Exception $e) {
            $response['msg'] = 'Caught exception: '. $e->getMessage();
            $response['errors'] = 1;
        }

        return [
            'msg' => $response['msg'],
            'error' => $response['errors']
        ];
    }

    public function deny(Request $request)
    {
        $response['msg'] = '';
        $response['errors'] = 0;

        try {
            /* Update Application Status to Pending */
            $apps= Application::find($request->id);
            $apps->status         = 5;
            $apps->updated_at     = Carbon::now();
            $apps->unsetEventDispatcher();
            $apps->update();

            ApplicationProcess::addApplicationProcess('Disapproved', $request->id, 5, Auth::id(), 'Application Disapproved');

            $response['msg'] = 'Application successfully Disapproved';

        } catch (Exception $e) {
            $response['msg'] = 'Caught exception: '. $e->getMessage();
            $response['errors'] = 1;
        }

        return [
            'msg' => $response['msg'],
            'error' => $response['errors']
        ];
    }

    /* For Reassigning Application that is on pending and Correction */
    public function show(int $id, Request $request)
    {

     $application = Application::with(['ApplicationProcess' => function($query) {
                return $query->whereIN('status', [4,6])->where('action', 'correction');
      }])->where('id', $id);


        return $application->first()->toJson(JSON_PRETTY_PRINT);
    }

    public function grabApplication(string $param, Request $request)
    {
        /* check if underwriter, supervisor or manager have pending application for review
           if has pending retrieve and must finish application review or else
           get queue application for review and tag to user.
        */
        $pending = Application::where('status', 2);
        $pending->where('underwriter' , Auth::id());


        if($pending->count() != 0) {

            return $pending->first()->toJson();

        } else {

            /* Retrieve Portfolio from */
            $get_acl_portfolio = New User;
            $portfolios = $get_acl_portfolio->associatedAclPortfolio();

            if(isset($portfolios['errors'])) {
                return $portfolios;
            }

            /* grab Application on queue Status */
            $queue = Application::where('status', 1);
            $queue->whereIn("portfolio", $portfolios);
            $queue->orderBy('created_at','desc');
            $get_result = $queue->first();

//            dd($get_result->toArray());

            /* Check if Application queue is not null */
            if($get_result == null) {
                $result['errors'] = true;
                $result['queue'] = 0;
                $result['msg'] =  '( 0 Queue ) No Application for Review <br>';
                return $result;
            }

            /* Update Application Status to Pending */
            $apps= Application::find($get_result->id);
            $apps->status         = 2;
            $apps->underwriter    = Auth::id();
            $apps->updated_at     = Carbon::now();
            $apps->unsetEventDispatcher();
            $apps->update();

            /* Add Application Process Status to Pending */
            $app_process= new ApplicationProcess;
            $app_process->action         = 'pending';
            $app_process->application_id = $get_result->id;
            $app_process->status         = 2;
            $app_process->user_id        = Auth::id();
            $app_process->description    = 'Application lock for review';
            $app_process->created_at     = Carbon::now();
            $app_process->updated_at     = Carbon::now();
            $app_process->save();

            return $get_result->toJson();
        }

    }

    public function destroy(int $id)
    {
        $application = Application::findOrFail($id)->delete();
        return $application;
    }

    public function status(Request $request, int $statusid)
    {
        $user = User::with('designation','groupPortfolio')->where('id', Auth::id());
        $designation = $user->first();

        if ($statusid == 2) {
            $applications =  Application::with('portfolioRelation')->whereIN('status', [$statusid, 6]);
        } else {
            $applications =  Application::with('portfolioRelation')->where('status', $statusid);
        }

        $portfolio = $designation->associatedAclPortfolio();

//        dd($portfolio);

        Switch (trim($designation->designation->name)) {
            case 'Loan Agent' :
                $applications->where('originator', Auth::id());
                break;
            default :
                    /* Check if ACL has Dedicated portfolio
                       if none get default Assign portfolio in users Group
                    */
                    if (isset($portfolio['errors'])) {
                        /* Get User Default Group Portfolio */
                        $default_group_portfolio = $designation->groupPortfolio->portfolio_id ?? '';

                        $applications->whereHas('portfolioRelation', function($query) use ($default_group_portfolio) {
                            $query->where('id', $default_group_portfolio);
                        });
                    } else {
                        $applications->whereIn('portfolio', $portfolio);
                    }
                break;
        }

        /* Build query for Search column */
            if ( isset($request['query']) ) {
                foreach($request['query'] as $column => $value) {
                    $applications->where($column,'like', '%'.$value.'%');
                }
            }

        /* Build query for order by column */
            if ( isset($request->orderBy) ) {
                $order_by = $request->orderBy;
                $direction = $request->ascending == 1 ? 'ASC' : 'DESC';
                $applications->orderBy($order_by, $direction);
            }


        $count = $applications->get()->count();
        $applications->skip($request->limit * ($request->page - 1))->take($request->limit);


       return [
        'data' => $applications->get()->toArray(),
        'count' => $count
       ];

    }


}
