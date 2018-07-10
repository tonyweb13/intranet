<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class CorrectiveAction extends Model
{
	protected $connection = 'hr';

    protected $table = 'nte_corrective_actions';

    protected $fillable = ['corrective_action'];

}
