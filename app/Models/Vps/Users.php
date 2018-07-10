<?php

namespace App\Models\Vps;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = ['name'];

    public function designation()
    {
        return $this->hasOne(Designation::class, 'id','designation_id');
    }

    public function location()
    {
        return $this->hasOne(OfficeLocation::class, 'id','work_location_id');
    }

    public function members()
    {
        return $this->hasMany(UsersGroups::class, 'teamlead_employee_no', 'employee_no');
    }
}
