<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $connection= 'loan';
    
    protected $table = 'portfolios';

    protected $fillable = ['name','description'];

}
