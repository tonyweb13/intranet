<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PurchasingSupplies extends Model
{
    protected $connection = 'admin';

    protected $fillable = [
        'control_number', 'department_id', 'location_id',
        'order_quantity', 'item_code', 'item_description',
        'unit', 'amount', 'total_amount', 'issued_quantity',
        'issued_date_received', 'pending_order_quantity',
        'pending_date_received', 'requested_id',
        'approved_id', 'request_received_id',
        'supplies_issued_id', 'supplies_received_id'
    ];
}
