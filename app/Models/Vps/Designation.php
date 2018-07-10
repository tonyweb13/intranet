<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designation';

    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'designation_id');
    }
}
