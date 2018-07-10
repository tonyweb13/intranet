<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AdjFees extends Model
{
    protected $connection = 'loan';

    protected $table = 'adj_fees';

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('F-d-Y');
    }

    protected $fillable = ['portfolio','loan_id'];
}
