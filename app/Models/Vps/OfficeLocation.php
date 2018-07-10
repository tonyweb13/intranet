<?php

namespace App\Models\Vps;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    protected $table = 'office_locations';

    protected $fillable = ['name','description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'work_location_id');
    }

}
