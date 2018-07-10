<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;

class PaymentManager extends Model
{

    protected $connection = 'loan';

    protected $table = 'payments_data';

    protected $fillable = ['payment_id',
                            'loan_number', 
                            'payment_line_type', 
                            'line_number',
                            'origination_date',
                            'effective_date',
                            'p_1',
                            'nf_1',
                            'nf_2',
                            'lt',
                            'ff',
                            'uff',
                            'p_2',
                            'a',
                            'mode',
                            'status1',
                            'rc',
                            'r_d',
                            'new_id',
                            'note',
                            'status2',
                            'rr',
                            'is_makeup',
                            'c_date',
                            'end_date',
                        ];

}