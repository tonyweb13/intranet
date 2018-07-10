<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    protected $table = 'cost_center';

    protected $fillable = ['name','description'];
}
