<?php

namespace App\BusinessLayer;

use App\Models\QualityAssurance\{
    CsrForm,
    CsrAudit,
    CsrAuditResult,
    Description
};
use DB;

class CreateAudit
{
    public function createForm($agent, $created_by, $supervisor_id, $type)
    {
        $inputs = [
            'employee_id' => $agent->employee_no,
            'location' => $agent->work_location_id,
            'created_by' => $created_by,
            'supervisor_id' => $supervisor_id,
            'type' => $type
        ];
        $form = CsrForm::create($inputs);

        return $form->id;
    }

    public function createAudit($csr_form_id, $category_type, $audit_value)
    {
        $inputs = [
            'csr_form_id' => $csr_form_id,
            'loan_id' => '',
            'audit_date' => \Carbon\Carbon::now(),
            'is_compliance' => true,
            'status' => true,
            'audit_type' => '',
        ];
        $audit = CsrAudit::create($inputs);

        $descriptions = Description::whereHas('subCategory.category', function ($query) use ($category_type) {
            $query->where('category_type', $category_type);
        })->get();

        foreach ($descriptions as $description) {
            $this->createAuditResult($audit->id, $description->id, $audit_value);
        }

        return response()->json();
    }

    protected function createAuditResult($csr_audit_id, $descriptions_id, $audit_value)
    {
        $inputs = [
            'csr_audit_id' => $csr_audit_id,
            'descriptions_id' => $descriptions_id,
            'result' => $audit_value,
        ];
        $result = CsrAuditResult::create($inputs);

        return $result;
    }
}