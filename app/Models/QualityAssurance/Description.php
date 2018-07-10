<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Description extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'sub_category_id', 'created_by', 'status', 'error_code'];

    protected $dates = ['deleted_at'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function csrAuditResult()
    {
        return $this->hasMany(CsrAuditResult::class, 'descriptions_id')->orderBy('sub_category_id');
    }
}
