<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $connection = 'loan';

    protected $fillable = ['name','code'];
}