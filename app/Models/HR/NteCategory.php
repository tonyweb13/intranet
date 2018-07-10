<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class NteCategory extends Model
{
	protected $connection = 'hr';

    protected $table = 'nte_categories';

    protected $fillable = ['name', 'description'];
}
