<?php

namespace App\Models\Action;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';
    
    protected $fillable = ['employee_no', 'survey_id', 'name', 'question_id'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
