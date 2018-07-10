<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\RequestPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestPaymentController extends Controller
{

    public function index()
    {
        $payment = RequestPayment::leftJoin('db_vps.departments', 'department_id','=','db_vps.departments.id')
            ->leftJoin('db_vps.users as u1', 'requested_id','=','db_vps.u1.id')
            ->leftJoin('db_vps.users as u2', 'noted_id','=','db_vps.u2.id')
            ->leftJoin('db_vps.users as u3', 'approved_id','=','db_vps.u3.id')
            ->leftJoin('db_loan.status_code as assist_stats', 'assistant_status','=','db_loan.assist_stats.id')
            ->leftJoin('db_loan.status_code as admin_stats', 'supervisor_status','=','db_loan.admin_stats.id')
            ->select('request_payments.*',
                'departments.name as dep_name',
                DB::raw('CONCAT(u1.first_name, " ", u1.last_name) AS requested_name'),
                DB::raw('CONCAT(u2.first_name, " ", u2.last_name) AS noted_name'),
                DB::raw('CONCAT(u3.first_name, " ", u3.last_name) AS approved_name'),
                DB::raw('assist_stats.name AS assistant_remark'),
                DB::raw('admin_stats.name AS supervisor_remark')
            )->orderBy('created_at', 'desc')->get();
        return response()->json($payment);
    }

    public function create(Request $request)
    {
        $payment = new RequestPayment;
        $payment->request_number = $request->request_number;
        $payment->department_id = $request->department_id;
        $payment->supplier = $request->supplier;
        $payment->payee = $request->payee;
        $payment->amount = $request->amount;
        $payment->due_date = $request->due_date;
        $payment->description = $request->description;
        $payment->requested_id = $request->requested_id;
        $payment->noted_id = $request->noted_id;
        $payment->approved_id = $request->approved_id;
        $payment->assistant_status = 2; //Status Code ( Pending = 2 ) 
        $payment->supervisor_status = 2; //Status Code ( Pending = 2 ) 
        $payment->save();
        return $payment;
    }

    // public function show(int $id, Request $request)
    // {
    //     $payment = RequestPayment::updateOrCreate(['id' => $id], $request->all());
    //     return $payment;
    // }

    // public function edit(int $id)
    // {
    //     $payment = RequestPayment::all()->where('id', $id)->first();
    //     return $payment;
    // }

    // public function destroy(int $id)
    // {
    //     $payment = RequestPayment::findOrFail($id)->delete();
    //     return response()->json($payment);
    // }

    public function approval(Request $request)
    {
        if($request->designation == 56){ //admin Assistant
            $approval = RequestPayment::where('id', '=', $request->request_id)
            ->update(['assistant_status' => $request->status, 'noted_id' => $request->employee_id]);

        } else {
            $approval = RequestPayment::where('id', '=', $request->request_id)
            ->update(['supervisor_status' => $request->status, 'approved_id' => $request->employee_id]);
        }

        return response()->json($approval);
    }

    public function requestor()
    {
        $payment = RequestPayment::leftJoin('db_vps.users as u2', 'noted_id','=','db_vps.u2.id')
            ->leftJoin('db_vps.users as u3', 'approved_id','=','db_vps.u3.id')
            ->leftJoin('db_loan.status_code as assist_stats', 'assistant_status','=','db_loan.assist_stats.id')
            ->leftJoin('db_loan.status_code as admin_stats', 'supervisor_status','=','db_loan.admin_stats.id')
            ->select('request_payments.*',
                DB::raw('CONCAT(u2.first_name, " ", u2.last_name) AS noted_name'),
                DB::raw('CONCAT(u3.first_name, " ", u3.last_name) AS approved_name'),
                DB::raw('assist_stats.name AS assistant_remark'),
                DB::raw('admin_stats.name AS supervisor_remark')
            )->where('request_payments.requested_id', Auth::user()->id)->get();
        return response()->json($payment);
    }
}
