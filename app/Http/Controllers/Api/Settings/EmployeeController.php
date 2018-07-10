<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vps\{
    Addresses,
    GovernmentIdentityNo
};

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = User::all();
        return response()->json($employee);
    }

    public function create(Request $request)
    {
        $request->validate([
            'emp_no' => 'required|integer',
            'user' => 'required',
            'password' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'mname' => 'required',
            'bday' => 'required|date',
            'mnumber' => 'required|integer',
            'banktype' => 'required',
            'accountno' => 'required|integer',
            'person_to_contact_in_case_of_emergency' => 'required',
            'contact_person_no' => 'required|integer',
            'relationship' => 'required',
        ]);

        $employee = new User;
        $employee->username = $request->user;
        $employee->password = MD5($request->password);
        $employee->first_name = $request->fname;
        $employee->last_name = $request->lname;
        $employee->middle_name = $request->mname;
        $employee->email_address = $request->email;
        $employee->birthday = $request->bday;
        $employee->employee_no = $request->emp_no;
        $employee->mobile_no = $request->mnumber;
        $employee->educational_institution = $request->school;
        $employee->year_graduated = $request->ygraduate;
        $employee->bank_type = $request->banktype;
        $employee->bank_account_no = $request->accountno;
        $employee->person_to_contact_in_case_of_emergency = $request->person_to_contact_in_case_of_emergency;
        $employee->contact_person_no = $request->contact_person_no;
        $employee->relationship = $request->relationship;
        $employee->save();
        return $employee;
    }

    public function show(int $id, Request $request)
    {
        $employee = User::updateOrCreate(['id' => $id], $request->all());

        if(!empty($request->current_address)){
            $address = Addresses::findOrFail($request->address_id);
            $address->current_address = $request->current_address;
            $address->save();
        }

        if(!empty($request->phil_health_number) || !empty($request->hmdf_number) || !empty($request->sss_number) || !empty($request->tin_number)){
            $government = GovernmentIdentityNo::findOrFail($request->government_credential_id);
            $government->phil_health_number = $request->phil_health_number;
            $government->hmdf_number = $request->hmdf_number;
            $government->sss_number = $request->sss_number;
            $government->tin_number = $request->tin_number;
            $government->save();
        }

        return $employee;
    }

    public function edit(int $id)
    {
        $employee = User::where('id', $id);
        $employeeInfo = $employee->with(['department', 'designation', 'employment_type', 'address','government_credential'])->first();
        return $employeeInfo;
    }

    public function updatePassword(Request $request)
    {     
        $validatedData = $request->validate([
            'password' => 'required|string|min:6',
            'employee_no' => 'required',
            'is_default_password' => 'required'
        ]);

        $updatePass = User::setPassword($request);

        return $updatePass;
    }

    public function destroy(int $id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();
        return response()->json($employee);
    }

    public function dropdown()
    {
        $employee = User::select('first_name','last_name','designation_id','id')->with('designation')
            ->whereHas('designation', function ($query) {
                return $query->whereIn('name', ['Underwriter', 'Underwriting Supervisor', 'Underwriting Specialist', 'Underwriting Team Lead']);
            });

        return response()->json($employee->get());
    }
}
