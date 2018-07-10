<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;

class BadABA extends Model
{
    protected $connection = 'loan';

    protected $table = 'badabas';

    protected $fillable = ['aba_number','reason'];
}
