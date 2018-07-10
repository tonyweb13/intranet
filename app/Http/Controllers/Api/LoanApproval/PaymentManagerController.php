<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime, DateTimeZone,Validator;

class PaymentManagerController extends Controller
{

    public function index()
    {
//        $paymentmanager = PaymentManager::all();
//
//        return response()->json($paymentmanager);
    }

    public function create(request $request)
    {
        $paymentmanager = new PaymentManager();
        $paymentmanager->payment_id = $request->payment_id;
        $paymentmanager->loan_number = $request->loan_number;
        $paymentmanager->payment_line_type = $request->payment_line_type;
        $paymentmanager->line_number = $request->line_number;
        $paymentmanager->origination_date = $request->origination_date;
        $paymentmanager->effective_date = $request->effective_date;
        $paymentmanager->p_1 = $request->p_1;
        $paymentmanager->nf_1 = $request->nf_1;
        $paymentmanager->nf_2 = $request->nf_2;
        $paymentmanager->lt = $request->lt;
        $paymentmanager->ff = $request->ff;
        $paymentmanager->uff = $request->uff;
        $paymentmanager->p_2 = $request->p_2;
        $paymentmanager->a = $request->a;
        $paymentmanager->mode = $request->mode;
        $paymentmanager->status1 = $request->status1;
        $paymentmanager->rc = $request->rc;
        $paymentmanager->r_d = $request->r_d;
        $paymentmanager->new_id = $request->new_id;
        $paymentmanager->note = $request->note;
        $paymentmanager->status2 = $request->status2;
        $paymentmanager->rr = $request->rr;
        $paymentmanager->is_makeup = $request->is_makeup;
        $paymentmanager->c_date = $request->c_date;
        $paymentmanager->end_date = $request->end_date;
        $paymentmanager->save();
    }

    public function searchApp(Request $request)
    {



        $paymentmanager = PaymentManager::where('loan_number', $request->loan_id)->where('portfolio', $request->portfolio);

        $result = $paymentmanager->get();
        $sum_p = 0;
        $sum_r = 0;
        $line_zero = 0;
        $loan_status = '';

        $effective_date = [];

        $numItems = count($result);
        $i = 0;

        $new_rows = [];

        /* RR Calculation */
        $rr = 0;
        foreach ($result as $value) {


            array_push($effective_date, $value->effective_date);

            if ($value->line_number == 0) {
                $line_zero = $value->p_1;
                $rr = $value->rr;
            }

            if ($value->line_number > 0 && $value->effective_date <= date('Y-m-d', strtotime(date("Y-m-d") . ' -1 day'))) {
                $sum_p += $value->p_2;
            }

            if ($value->status1 == 'Rejected' || $value->status1 == 'Skip payment') {
                $sum_r += $value->a;
            }

            if (++$i === $numItems) {
                $loan_status = $value->status2;
            }

            $value['new_effective_date'] = '';
            $value['new_adding_pay_down'] = '';

            $request_effective_date = array_map('trim',json_decode($request->pifdates, true));
            $request_amount_pay_down = array_map('trim',json_decode($request->pay_down_amounts, true));

            $search_effect_date_in_new = array_search($value->effective_date, $request_effective_date);
            if ($search_effect_date_in_new) {
                $value['new_effective_date'] = $request_effective_date[$search_effect_date_in_new];
                $value['new_adding_pay_down'] = $request_amount_pay_down['amount'.substr($search_effect_date_in_new, -1)];
            }



            array_push($new_rows, $value);
        }


        $remaining = $line_zero-$sum_p;


        $date_diff = 0;
        if(!empty($request->pifdate)) {
            $date1 = new DateTime($request->pifdate);
            $date2 = new DateTime(max($effective_date));
            $date_diff = $date2->diff($date1)->format("%a");
//            echo round($date_diff*($rr*$remaining/365)+$sum_r, 2);
        }


        $calculated = [
            'rows' => $new_rows,
            'sum_p' => $sum_p,
            'line_zero' => $line_zero,
            'remaining' => $remaining,
            'max_effective_date' => max($effective_date),
            'sum_r' => $sum_r,
            'loan_status' => $loan_status,
            'loan_status_output_info' => (empty($loan_status)) ? "New Loan" : $loan_status,
            'pif_finance_fee' => (empty($request->pifdate)) ? "No PIF Date" : round($date_diff*($rr*$remaining/365)+$sum_r, 2),
            'total_pif_amount' =>  (empty($request->pifdate)) ? "No PIF Date" : round(( round($date_diff*($rr*$remaining/365)+$sum_r, 2)+$remaining), 2),
            'new_format_paydown' => [
                'rr' => $rr,
                'rr_01' => '',
                'rr_02' => '',
                'rr_date' => '',
            ]
        ];

        return response()->json($calculated);
    }

    public function edit(int $id)
    {
       $paymentmanager = PaymentManager::all()->where('id', $id)->first();

       return $paymentmanager;
    }

    public function destroy(int $id)
    {
        $paymentmanager = PaymentManager::findOrFail($id)->delete();

        return $paymentmanager;
    }

}
