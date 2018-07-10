<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'created_by', 'status', 'category_type',  'order'];

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class, 'id');
    }
}
