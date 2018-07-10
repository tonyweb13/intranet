<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class Gravity extends Model
{
	protected $connection = 'hr';

    protected $table = 'nte_gravitys';

    protected $fillable = ['gravity'];

    
}
