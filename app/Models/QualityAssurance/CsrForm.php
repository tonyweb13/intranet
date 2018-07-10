<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CsrForm extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'supervisor_id',
        'location',
        'score',
        'is_compliance',
        'created_by',
        'corrective_action',
        'is_agent_signed',
        'agent_signed_date',
        'is_supervisor_signed',
        'supervisor_signed_date',
        'status',
        'type',
    ];

    protected $dates = ['deleted_at'];

    public function csrAudit()
    {
        return $this->hasMany(CsrAudit::class);
    }

}
