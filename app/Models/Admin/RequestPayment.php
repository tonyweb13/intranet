<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RequestPayment extends Model
{
    protected $connection = 'admin';

    protected $fillable = ['request_number', 'department_id', 'supplier', 'payee', 'amount', 'due_date', 'description', 'requested_id', 'noted_id', 'approved_id'];
}
