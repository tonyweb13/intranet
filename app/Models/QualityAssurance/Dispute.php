<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;

class Dispute extends BaseModel
{
    protected $fillable = ['csr_audit_result_id', 'comments', 'status'];

    public function csrAuditResult()
    {
        return $this->belongsTo(CsrAuditResult::class);
    }

    public function feedBack()
    {
        return $this->hasOne(DisputesFeedback::class);
    }
}
