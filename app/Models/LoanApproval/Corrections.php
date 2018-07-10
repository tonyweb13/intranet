<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;

class Corrections extends Model
{
    protected $connection = 'loan';

    protected $table = 'corrections';

    public function correctionItems()
    {
        return $this->hasMany(Corrections::class, 'parent_correction_id', 'id');
    }

}
