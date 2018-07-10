<?php

namespace App\Models\Tk;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tk\Schedules;

class ShiftActivities extends Model
{
    protected $connection = 'tk';

    protected $table = 'shift_activities';

    public static function isClockIn()
    {
        $activity_in = self::where('shift_activity_name', 'in')->first();

        $schedules = Schedules::getTodaySchedule();
        print_r($sched->date_name);
    }

    protected $fillable = ['name','class','label_name','icon','description'];
}
