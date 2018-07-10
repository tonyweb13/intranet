<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;

class ReAssign extends Model
{
    protected $connection = 'loan';

    protected $table = 're_assigns';

    protected $fillable = ['portfolio_id', 'loan_id', 'current_status', 'current_approver', 'reassign_approver'];

}