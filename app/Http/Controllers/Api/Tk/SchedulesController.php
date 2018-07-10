<?php
declare(strict_types=1);

namespace App\Http\Controllers\API\TK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tk\Schedules;
use Illuminate\Support\Facades\Auth;

class SchedulesController extends Controller
{

    public function index()
    {  
       $schedule = Schedules::all();
       return response()->json($schedule);
    }

    public function create(Request $request)
    {
        $schedule = new Schedules;
        $auth = Auth::user()->id;
        $schedule->user_id = $request->user_id;
        $schedule->work_week_no = $request->work_week;
        $schedule->sunday = $request->sunday;
        $schedule->monday = $request->monday;
        $schedule->tuesday = $request->tuesday;
        $schedule->wednesday = $request->wednesday;
        $schedule->thursday = $request->thursday;
        $schedule->friday = $request->friday;
        $schedule->saturday = $request->saturday;
        $schedule->start_date = date_format(date_create($request->start_date),'Y-m-d H:i:s');
        $schedule->end_date = date_format(date_create($request->end_date),'Y-m-d H:i:s');
        $schedule->created_by = $auth;        
        $schedule->save();

        return $schedule;
    }

    public function show(int $id, Request $request)
    {
        $schedule = Schedules::updateOrCreate(['id' => $id], $request->all());
        return $schedule;
    }

    public function edit(int $id)
    {
        $schedule = Schedules::all()->where('id', $id)->first();
        return $schedule;
    }

    public function destroy(int $id)
    {
        $schedule = Schedules::findOrFail($id);
        $schedule->delete();
        return response()->json($schedule);
    }

    public function dropdown()
    {
        $schedule = Schedules::select('name as value','name as text')->get();
        return response()->json($schedule);
    }
}
