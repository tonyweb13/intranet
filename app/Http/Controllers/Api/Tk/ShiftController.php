<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Tk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tk\Shifts;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function index()
    {
        $shift = Shifts::all();
        return response()->json($shift);
    }

    public function create(Request $request)
    {
        $shift = new Shifts;
        $shift->name = $request->name;
        $shift->description = $request->description;
        $shift->start = date("H:i:s", strtotime($request->start));
        $shift->end = date("H:i:s", strtotime($request->end));
        $shift->is_enable = $request->is_enable;
        $shift->save();

        return $shift;
    }

    public function show(int $id, Request $request)
    {
        $shift = Shifts::updateOrCreate(['id' => $id], $request->all());
        return $shift;
    }

    public function edit(int $id)
    {
        $shift = Shifts::all()->where('id', $id)->first();
        return $shift;
    }

    public function destroy(int $id)
    {
        $shift = Shifts::findOrFail($id);
        $shift->delete();
        return response()->json($shift);
    }

    public function dropdown()
    {
        $shift = Shifts::select('name as value','name as text')->get();
        return response()->json($shift);
    }

}
