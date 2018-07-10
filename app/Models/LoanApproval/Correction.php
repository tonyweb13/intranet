<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;

class Correction extends Model
{
    protected $connection = 'loan';

    protected $table = 'corrections';

    protected $fillable = ['correction_name', 'parent_correction_id', 'code', 'description'];
}
