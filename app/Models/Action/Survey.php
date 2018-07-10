<?php

namespace App\Models\Action;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'survey_management';
    
    protected $fillable = ['survey_name', 'introduction', 'conclusion', 'created_by'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
