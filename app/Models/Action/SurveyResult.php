<?php

namespace App\Models\Action;

use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    protected $table = 'surveys';
    
    protected $fillable = ['employee_no', 'survey_id', 'name', 'question_id', 'user_question', 'user_answer'];

}
