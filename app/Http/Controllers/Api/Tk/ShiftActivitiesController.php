<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Tk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tk\ShiftActivities;
use App\User;

class ShiftActivitiesController extends Controller
{

    public function index()
    {  
       $shift_activity = ShiftActivities::all();
       return response()->json($shift_activity);
    }

    public function create(Request $request)
    {
        $shift_activity = new ShiftActivities;
        $shift_activity->name = $request->name;
        $shift_activity->class = $request->class;
        $shift_activity->label_name = $request->label_name;
        $shift_activity->icon = $request->icon;
        $shift_activity->description = $request->description;
        $shift_activity->save();

        return $shift_activity;
    }

    public function show(int $id, Request $request)
    {
        $shift_activity = ShiftActivities::updateOrCreate(['id' => $id], $request->all());
        return $shift_activity;
    }

    public function edit(int $id)
    {
        $shift_activity = ShiftActivities::all()->where('id', $id)->first();
        return $shift_activity;
    }

    public function destroy(int $id)
    {
        $shift_activity = ShiftActivities::findOrFail($id);
        $shift_activity->delete();

        return response()->json($shift_activity);
    }

    public function dropdown()
    {
        $shift_activity = ShiftActivities::select('name as value','name as text')->get();
        return response()->json($shift_activity);
    }

}
