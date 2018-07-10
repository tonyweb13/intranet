<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends BaseModel
{
    protected $fillable = ['category_type','deleted_at'];

    public function categoryTypes()
    {
        return $this->hasMany(Category::class);
    }
}
