<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;

class FormType extends BaseModel
{
    protected $fillable = ['name'];

    public function forms()
    {
        return $this->hasMany(CsrForm::class);
    }
}
