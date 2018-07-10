<?php

namespace App\Http\Controllers\Api\LoanApproval;


use App\Http\Controllers\Controller;
use App\Models\LoanApproval\ReAssign;
use App\Models\LoanApproval\Application;
use App\Models\LoanApproval\ApplicationProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class ReAssignController extends Controller
{

    public function index()
    {
        $reassign = ReAssign::all();
        
        return response()->json($reassign);
    }

    public function getUnderwriters(request $request)
    {
        $underwriters = User::with('designation');

        $underwriters->whereHas('designation', function($query){
            $query->whereIN('name', ['Underwriter', 'Underwriting Specialist', 'Underwriting Supervisor', 'Underwriting Team Lead']);
        });

        return response()->json($underwriters->get(['id','employee_no','first_name', 'last_name']));
    }


    public function assignUnderwriter(request $request)
    {

        try
        {

            $apps = Application::find($request->appid);
            $apps->status         = 2;
            $apps->underwriter    = $request->underwriter_id;
            $apps->updated_at     = Carbon::now();
            $apps->unsetEventDispatcher();
            $apps->save();

            /* Add Application Process Status to Pending */
            $app_process= new ApplicationProcess;
            $app_process->action         = 'reassign';
            $app_process->application_id = $request->appid;
            $app_process->status         = 2;
            $app_process->user_id        = Auth::id();
            $app_process->description    = $request->underwriter_id;
            $app_process->created_at     = Carbon::now();
            $app_process->updated_at     = Carbon::now();
            $app_process->save();

            return $apps;

        } catch (\Exception $e) {

            $response['errors'] = 1;
            $response['msg'] = $e->getMessage();

            return $response;
        }
    }

    public function create(request $request)
    {
        $reassign = new ReAssign();
        $reassign->portfolio_id = $request->portfolio_id;
        $reassign->loan_id = $request->loan_id;
        $reassign->current_status = $request->current_status;
        $reassign->current_approver = $request->current_approver;
        $reassign->reassign_approver = $request->reassign_approver;
        $reassign->save();

        return $reassign;
    }

    public function show(int $id, Request $request)
    {
        $reassign = ReAssign::updateOrCreate(['id' => $id], $request->all());

        return $reassign;
    }

    public function edit(int $id)
    {
       $reassign = ReAssign::all()->where('id', $id)->first();

       return $reassign;
    }

    public function destroy(int $id)
    {
        $reassign = ReAssign::findOrFail($id)->delete();

        return response()->json($reassign);
    }

    public function getAvailableAppForReassignment()
    {
//        $reassign = Application::with(['ApplicationProcess' =>  function ($query) {
//
//            foreach ($query as $inqeury) {
//
//                $inqeury->whereIN('status', [2,4,6])->orderBy('created_at', 'desc')->first();
//                return $inqeury;
//            }
//            dd($data);
//
//        }]);
//
//        $reassign->whereIn('status', [2, 4, 6]);
//
////        dd($reassign->get()->toArray());
//
//        if ( $reassign->count() >= 1) {
//            return response()->json($reassign->first());
//        } else {
//            return response()->json(['error'=> true, 'msg' => 'unable to reassign application']);
//        }

    }




    public function getLoanInfo(string $loan_id)
    {       
        $reassign = Application::with(['ApplicationProcess' =>  function ($query) {
                         return $query->whereIN('status', [2,4,6])->orderBy('created_at', 'desc')->first();
                }])
            ->whereHas('ApplicationProcess', function ($query) {
                return $query->orderBy('created_at', 'desc');
            });
        $reassign->whereIn('status', [2, 4, 6]);
        $reassign->where('loan_no', $loan_id);

        if ( $reassign->count() >= 1) {
                return response()->json($reassign->first());
        } else {
                return response()->json(['error'=> true, 'msg' => 'unable to reassign application']);
        }

    }

}
