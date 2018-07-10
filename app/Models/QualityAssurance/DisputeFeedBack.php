<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;

class DisputeFeedBack extends BaseModel
{
    protected $fillable = ['dispute_id', 'comments', 'status'];

    public function feedback()
    {
        return $this->belongsTo(Dispute::class);
    }
}
