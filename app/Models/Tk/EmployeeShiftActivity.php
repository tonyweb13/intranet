<?php

namespace App\Models\Tk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Tk\Schedules;
use App\Models\Tk\ShiftActivities;
use Carbon\Carbon;

class EmployeeShiftActivity extends Model
{
    protected $connection = 'tk';
    protected $table = 'employee_shift_activity';

    public function getUserIdAttribute($value)
    {
        return $value.ucfirst('-crisanto');
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = Auth::id();
    }

    public function save(array $options = array())
    {
        $this->start =  date('Y-m-d H:i:s');
        parent::save($options);
    }

    public function newActivity( string $activity_name, string $description )
    {
        $this->user_id = Auth::id();
        $this->shift_activity_name = $activity_name;
        $this->description = $description;
        $this->save();
        return $this;
    }

    private static function lastActivity() : int
    {
        return self::where('user_id', Auth::id())->max('id');
    }

//    private static function isClockIn() : bool
//    {
//
//    }
}
