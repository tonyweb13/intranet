<?php

namespace App\Models\QualityAssurance;

use Illuminate\Database\Eloquent\Model;

class ClarificationFeedBack extends BaseModel
{
    protected $fillable = ['clarification_id', 'comments', 'status'];

    public function clarification()
    {
        return $this->belongsTo(Clarification::class);
    }
}
