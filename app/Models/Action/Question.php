<?php

namespace App\Models\Action;

use Illuminate\Database\Eloquent\Model;
use Validator, Input, Image, Carbon\Carbon, File, Storage;

class Question extends Model
{
    protected $table = 'survey_questions';
    
    protected $fillable = ['survey_id', 'survey_type', 'question', 'answers', 'image', 'created_by'];

    public function getAnswersAttribute($value)
    {
        return unserialize($value);
    }

    public function getImageAttribute($value)
    {
        $tmp = Storage::url('survey_form/' .$value);

        return $tmp;
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
