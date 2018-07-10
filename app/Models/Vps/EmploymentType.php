<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    protected $table = 'employment_type';

    protected $fillable = ['name','description'];

}
