<?php

namespace App\Http\Controllers\Api\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Nte;
use App\Models\HR\NteFormList;
use App\Models\Vps\Users;
use App\Models\Vps\Designation;
use App\Models\Vps\Department;

use Illuminate\Http\Request;

class NteController extends Controller
{

    public function index()
    {
        $nte = Nte::leftJoin('db_vps.departments', 'department','=','db_vps.departments.id')
        ->leftJoin('db_hr.nte_form_lists', 'nte_type','=','db_hr.nte_form_lists.id')
        ->select('ntes.*', 'departments.name as dep_name', 'nte_form_lists.name as nte_type_name')    
        ->get();

        return $nte;

        // $nte = Nte::with(['nteFormList'])->first();
        // return $nte;
    }

    public function create(Request $request)
    {
        $nte = new Nte;
        $nte->nte_type = $request->nte_type;
        $nte->employee_id = $request->employee_id;
        $nte->email = $request->email;
        $nte->first_name = $request->first_name;
        $nte->last_name = $request->last_name;
        $nte->date = date("Y-m-d H:i:s", strtotime($request->date));
        $nte->role = $request->role;
        $nte->department = $request->department;
        $nte->save();
        
        return $nte;
    }

    public function show(int $id, Request $request)
    {
        $nte = Nte::updateOrCreate(['id' => $id], $request->all());

        return $nte;
    
    }

    public function edit(int $id)
    {
        $nte = Nte::all()->where('id', $id)->first();

        return $nte;
    }

    public function destroy(int $id)
    {
        $nte = Nte::findOrFail($id);
        $nte->delete();

        return response()->json($nte);
    }

    public function getUser($emp_no)
    {
        
        $user = Users::where('employee_no', $emp_no)->first();
        if ($user) {
            $designation = Designation::where('id', $user->designation_id)->first();
            $department = Department::where('id', $user->department_id)->first();
        } else {
            $designation = null;
            $department = null;
        }

        return response()->json([
            'user' => $user,
            'department' => $department,
            'role' => $designation
        ]);
    }

    public function getNte(int $id)
    {
        $nte = Nte::where('id', $id)->get();

        return response()->json($nte);
    }
}
