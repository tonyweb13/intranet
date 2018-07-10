<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $connection = 'loan';

    protected $fillable = ['application_id','user_id','loan_no', 'status', 'notes'];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

}