<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CsrAudit extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'csr_form_id',
        'loan_id', 'portfolio',
        'origination_app',
        'qa_agent_id',
        'audit_date',
        'call_type',
        'score',
        'is_compliance',
        'audit_name',
        'status',
        'is_agent_signed',
        'agent_signed_date',
        'is_supervisor_signed',
        'supervisor_signed_date',
        'audit_type'
    ];

    protected $dates = ['deleted_at'];

    public function csrForm()
    {
        return $this->belongsTo(CsrForm::class, 'csr_form_id');
    }

    public function csrAuditResult()
    {
        return $this->hasMany(CsrAuditResult::class);
    }

    public function commendation()
    {
        return $this->hasOne(Commendations::class);
    }

    public function getAuditWithResultsByCsrForm(int $form_id)
    {
        return $this->with('csrAuditResult.description.subCategory')
            ->where('csr_form_id', $form_id)
            ->get();
    }

    public function portfolio()
    {
        return $this->hasOne(Portfotlio::class);
    }
}
