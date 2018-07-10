<?php

namespace App\Models\Tk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Tk\Shifts;

class Schedules extends Model
{
    protected $connection = 'tk';

    protected $table = 'schedules';

    public static function getWorkWeekSchedule()
    {
        $date = Carbon::now(); // or $date = new Carbon();
        $week_start =  $date->startOfWeek()->format('Y-m-d');
        $week_end =  $date->endOfWeek()->format('Y-m-d');

        return self::where('user_id', Auth::id())
            ->where('work_week_no', $date->format('W'))
            ->where('start_date', $week_start)->where('end_date', $week_end)
            ->first();
    }

    public static function getTodaySchedule()
    {
        $schedule = Schedules::getWorkWeekSchedule();
        $Today = strtolower(Carbon::now()->format('l'));

        $return['shifts'] = Shifts::whereId($schedule[$Today])->first();
        $return['date_name'] = $Today;
        $return['schedule_id'] = $schedule[$Today];
        return (object) $return;
    }

    protected $fillable = ['user_id','work_week_no','sunday','monday','tuesday','wednesday','thursday','friday','saturday','start_date','end_date','created_by','update_by'];


}
