<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['name', 'category_id', 'created_by', 'status', 'order'];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function description()
    {
        return $this->hasMany(Description::class);
    }
}
