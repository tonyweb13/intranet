<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\PaymentChange;
use App\Models\LoanApproval\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime, DateTimeZone,Validator;

class PaymentChangeController extends Controller
{

    public function index()
    {
        $paymentchange = PaymentChange::all();
        
        return response()->json($paymentchange);
    }

    public function create(request $request)
    {
        $paymentchange = new PaymentChange();
        $paymentchange->loan_id = $request->loan_id;
        $paymentchange->last_name = $request->last_name;
        $paymentchange->request_type = $request->request_type;
        $paymentchange->effective_date = $request->effective_date;
        $paymentchange->confirmed_amount = $request->confirmed_amount;
        $paymentchange->confirmed_date = $request->confirmed_date;
        $paymentchange->employee_name = $request->employee_name;
        $paymentchange->status = $request->status;
        $paymentchange->payment_type = $request->payment_type;
        $paymentchange->save();
    }

    public function show(int $id, Request $request)
    {
        $paymentchange = PaymentChange::find($id);

        return $paymentchange->toJson(JSON_PRETTY_PRINT);
    }

    public function edit(int $id)
    {
       $paymentchange = PaymentChange::all()->where('id', $id)->first();

       return $paymentchange;
    }

    public function destroy(int $id)
    {
        $paymentchange = PaymentChange::findOrFail($id)->delete();

        return $paymentchange;
    }

    public function paymentType()
    {
        $paymenttype = PaymentType::select('id as value','name as text')->get();

        return response()->json($paymenttype);   
    }

}
