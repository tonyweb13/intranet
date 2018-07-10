<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $table = 'rules';

    protected $casts = [
        'rules' => 'array',
    ];

    protected $fillable = ['user_id', 'rules'];

}
