<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class UsersGroups extends Model
{
    protected $table = 'users_groups';

    protected $fillable = ['employee_no'];

    public function getUserInfo()
    {
        return $this->belongsTo(Users::class, 'employee_no', 'employee_no');
    }

    public function location()
    {
        return $this->hasOne(OfficeLocation::class, 'id','work_location_id');
    }

    public function getPortfolioName()
    {
        return $this->hasOne(Portfolio::class, 'id','portfolio_id');
    }


}
