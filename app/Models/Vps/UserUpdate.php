<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class UserUpdate extends Model
{
    protected $table = 'user_changes';

    protected $fillable = ['user_id', 'user_changes'];
}
