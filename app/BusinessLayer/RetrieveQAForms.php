<?php

namespace App\BusinessLayer;

use App\Models\QualityAssurance\CsrForm;
use App\Models\QualityAssurance\FormType;
use DB;

class RetrieveQAForms
{
    public function getAllForms($month, $type)
    {
        if ($type) {
            $list = CsrForm::whereYear('created_at', '=', (int) date('Y'))
                ->whereMonth('created_at', '=', (int) $month)
                ->where('type', $type)
                ->with('csrAudit')
                ->orderBy('created_at')->get();
        } else {
            $list = CsrForm::whereYear('created_at', '=', (int) date('Y'))
                ->whereMonth('created_at', '=', (int) $month)
                ->with('csrAudit')
                ->orderBy('created_at')->get();
        }

        return $list;
    }

    public function retrieveFormSearch($month, $type, $id)
    {
        if ($type && $id) {
            $list = CsrForm::whereYear('created_at', '=', (int) date('Y'))
                ->whereMonth('created_at', '=', (int) $month)
                ->where('employee_id', $id)
                ->where('type', $type)
                ->with('csrAudit')
                ->orderBy('created_at')->get();
        } elseif ($type && !$id) {
            $list = CsrForm::whereYear('created_at', '=', (int) date('Y'))
                ->whereMonth('created_at', '=', (int) $month)
                ->where('type', $type)
                ->with('csrAudit')
                ->orderBy('created_at')->get();
        } elseif (!$type && $id) {
            $list = CsrForm::whereYear('created_at', '=', (int) date('Y'))
                ->whereMonth('created_at', '=', (int) $month)
                ->where('employee_id', $id)
                ->with('csrAudit')
                ->orderBy('created_at')->get();
        } else {
            $list = CsrForm::whereYear('created_at', '=', (int) date('Y'))
                ->whereMonth('created_at', '=', (int) $month)
                ->with('csrAudit')
                ->orderBy('created_at')->get();
        }

        return $list;
    }

    public function processFormListData($results)
    {
        $forms = [];
        $data = [];
        $users = new Users();
        $users_list = $users->allUsers(false)->toArray();
        $form_type = $this->formType();
        $locations = $users->officeLocation()->toArray();
        foreach ($results as $form) {
            $last_audit = end($form->csrAudit);
            $audit_count = count($form->csrAudit);
            $data['id'] = $form->id;
            $data['employee_no'] = $form->employee_id;
            $data['name'] = $users_list[$form->employee_id];
            $data['supervisor'] = $users_list[$form->supervisor_id];
            $data['location'] = $locations[$form->location];
            $data['score'] = $form->score . '%';
            $data['compliance'] = ($form->is_compliance) ? 'Pass' : 'Fail';
            $data['created_by'] = $users_list[$form->created_by];
            $data['type'] = $form_type[$form->type];
            $data['created_at'] = $form->created_at->format('d-m-Y H:i:s');
            $data['audit_count'] = $audit_count;
            $data['audit_status'] = ($last_audit[0]['status']) ? 'Done Audit ' . $audit_count : 'Ongoing Audit ' . $audit_count;
                array_push($forms, $data);
        }

        return $forms;
    }

    public function formType()
    {
        $list = FormType::all()->pluck('name', 'id');

        return $list;
    }

    public function createVSelectArray($data)
    {
        $users = [];
        foreach ($data->toArray() as $key => $value) {
            $user['text'] = $value;
            $user['value'] = $key;
            array_push($users, $user);
        }

        return $users;
    }
}