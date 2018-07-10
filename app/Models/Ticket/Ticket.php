<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = ['department_to', 'date_from', 'date_to', 'description', 'priority', 'issue'];
}
