<?php

namespace App\Models\Tk;

use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    protected $connection = 'tk';

    protected $table = 'shifts';

    protected $fillable = ['name','description','start','end','is_enable'];
}
