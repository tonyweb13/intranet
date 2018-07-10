<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\PurchasingSupplies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasingSuppliesController extends Controller
{

    public function index()
    {
        $supplies = PurchasingSupplies::leftJoin('db_vps.departments', 'department_id','=','db_vps.departments.id')
            ->leftJoin('db_vps.office_locations', 'location_id','=','db_vps.office_locations.id')
            ->leftJoin('db_vps.users as u1', 'requested_id','=','db_vps.u1.id')
            ->leftJoin('db_vps.users as u2', 'approved_id','=','db_vps.u2.id')
            ->leftJoin('db_vps.users as u3', 'request_received_id','=','db_vps.u3.id')
            ->leftJoin('db_vps.users as u4', 'supplies_issued_id','=','db_vps.u4.id')
            ->leftJoin('db_vps.users as u5', 'supplies_received_id','=','db_vps.u5.id')
            ->leftJoin('db_loan.status_code as assist_stats', 'assistant_status','=','db_loan.assist_stats.id')
            ->leftJoin('db_loan.status_code as admin_stats', 'supervisor_status','=','db_loan.admin_stats.id')
            ->select('purchasing_supplies.*',
                'departments.name as dep_name',
                'office_locations.name as loc_name',
                DB::raw('CONCAT(u1.first_name, " ", u1.last_name) AS requested_name'),
                DB::raw('CONCAT(u2.first_name, " ", u2.last_name) AS approved_name'),
                DB::raw('CONCAT(u3.first_name, " ", u3.last_name) AS request_received_name'),
                DB::raw('CONCAT(u4.first_name, " ", u4.last_name) AS supplies_issued_name'),
                DB::raw('CONCAT(u5.first_name, " ", u5.last_name) AS supplies_received_name'),
                DB::raw('assist_stats.name AS assistant_remark'),
                DB::raw('admin_stats.name AS supervisor_remark')
            )->orderBy('created_at', 'desc')->get();
        return response()->json($supplies);
    }

    public function create(Request $request)
    {
        $supplies = new PurchasingSupplies;
        $supplies->control_number = $request->control_number;
        $supplies->department_id = $request->department_id;
        $supplies->location_id = $request->location_id;
        $supplies->order_quantity = $request->order_quantity;
        $supplies->item_code = $request->item_code;
        $supplies->item_description = $request->item_description;
        $supplies->unit = $request->unit;
        $supplies->amount = $request->amount;
        $supplies->total_amount = $request->total_amount;
        $supplies->issued_quantity = $request->issued_quantity;
        $supplies->issued_date_received = $request->issued_date_received;
        $supplies->pending_order_quantity = $request->pending_order_quantity;
        $supplies->pending_date_received = $request->pending_date_received;
        $supplies->requested_id = $request->requested_id;
        $supplies->approved_id = $request->approved_id;
        $supplies->request_received_id = $request->request_received_id;
        $supplies->supplies_issued_id = $request->supplies_issued_id;
        $supplies->supplies_received_id = $request->supplies_received_id;
        $supplies->assistant_status = 2; //Status Code ( Pending = 2 ) 
        $supplies->supervisor_status = 2; //Status Code ( Pending = 2 ) 
        $supplies->save();
        return $supplies;
    }

    // public function show(int $id, Request $request)
    // {
    //     $supplies = PurchasingSupplies::updateOrCreate(['id' => $id], $request->all());
    //     return $supplies;
    // }

    // public function edit(int $id)
    // {
    //     $supplies = PurchasingSupplies::all()->where('id', $id)->first();
    //     return $supplies;
    // }

    // public function destroy(int $id)
    // {
    //     $supplies = PurchasingSupplies::findOrFail($id)->delete();
    //     return response()->json($supplies);
    // }

    public function approval(Request $request)
    {
        if($request->designation == 56){ //admin Assistant
            $approval = PurchasingSupplies::where('id', '=', $request->request_id)
            ->update(['assistant_status' => $request->status, 'supplies_issued_id' => $request->employee_id, 'supplies_received_id' => $request->employee_id]);

        } else {
            $approval = PurchasingSupplies::where('id', '=', $request->request_id)
            ->update(['supervisor_status' => $request->status, 'approved_id' => $request->employee_id]);
        }

        return response()->json($approval);
    }

    public function requestor()
    {
        $supplies = PurchasingSupplies::leftJoin('db_vps.users as u2', 'approved_id','=','db_vps.u2.id')
            ->leftJoin('db_vps.users as u3', 'request_received_id','=','db_vps.u3.id')
            ->leftJoin('db_vps.users as u4', 'supplies_issued_id','=','db_vps.u4.id')
            ->leftJoin('db_vps.users as u5', 'supplies_received_id','=','db_vps.u5.id')
            ->leftJoin('db_loan.status_code as assist_stats', 'assistant_status','=','db_loan.assist_stats.id')
            ->leftJoin('db_loan.status_code as admin_stats', 'supervisor_status','=','db_loan.admin_stats.id')
            ->select('purchasing_supplies.*',
                DB::raw('CONCAT(u2.first_name, " ", u2.last_name) AS approved_name'),
                DB::raw('CONCAT(u4.first_name, " ", u4.last_name) AS supplies_issued_name'),
                DB::raw('CONCAT(u5.first_name, " ", u5.last_name) AS supplies_received_name'),
                DB::raw('assist_stats.name AS assistant_remark'),
                DB::raw('admin_stats.name AS supervisor_remark')
            )->where('purchasing_supplies.requested_id', Auth::user()->id)->get();
        return response()->json($supplies);
    }

}
