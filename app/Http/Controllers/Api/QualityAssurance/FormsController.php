<?php

namespace App\Http\Controllers\Api\QualityAssurance;

use App\BusinessLayer\CreateAudit;
use App\BusinessLayer\RetrieveQAForms;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormsController extends Controller
{
    public function allForms(Request $request)
    {
        $forms = new RetrieveQAForms();
        if ($request->type) {
            $type = $request->type;
        } else {
            $type = 0;
        }

        $month = $request->session()->get('month');
        $results = $forms->getAllForms($month, $type);
        $list = $forms->processFormListData($results);

        return response()->json($list);

    }

    public function formType()
    {
        $forms = new RetrieveQAForms();
        $results = $forms->formType();
        $list = $forms->createVSelectArray($results);

        return response()->json($list);
    }

    public function searchForms(Request $request)
    {
        $forms = new RetrieveQAForms();
        $role = '';
        $month = $request->session()->get('month');
        $results = $forms->retrieveFormSearch($month, $request->type, $request->employee_id);
        $list = $forms->processFormListData($results);

        return response()->json($list);
    }

    public function createNewForm(Request $request)
    {
        $this->validate($request, ['employee_id' => 'required|integer']);
        $month = $request->session()->get('month');

        $agent = User::where('employee_no', $request->employee_id)->first();
        //TODO: Replace static values once data for agents is available
        $created_by = 20160813;
        $supervisor_id = 20160030;
        $type = ($agent->type) ? $agent->type : 1;
        $audit_value = 1;

        $audits = new CreateAudit();
        $forms = new RetrieveQAForms();
        $csr_form_id = $audits->createForm($agent, $created_by, $supervisor_id, $type);
        $audits->createAudit($csr_form_id, $type, $audit_value);
        $results = $forms->retrieveFormSearch($month, $type, $request->employee_id);
        $list = $forms->processFormListData($results);

        return response()->json($list);
    }
}
