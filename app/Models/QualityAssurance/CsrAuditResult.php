<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CsrAuditResult extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'csr_audit_id',
        'descriptions_id',
        'result',
        'comments',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function csrAudit()
    {
        return $this->belongsTo(CsrAudit::class, 'csr_audit_id');
    }

    public function description()
    {
        return $this->belongsTo(Description::class, 'descriptions_id');
    }

    public function dispute()
    {
        return $this->hasMany(Dispute::class);
    }

    public function clarification()
    {
        return $this->hasMany(Clarification::class);
    }

    public function getAuditResult(int $audit_id)
    {
        $this->where('csr_audit_id', $audit_id);
    }
}
