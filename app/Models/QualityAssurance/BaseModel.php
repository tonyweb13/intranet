<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    protected $connection = 'qa';
}