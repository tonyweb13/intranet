<?php

namespace App\Http\Controllers\Api\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\CorrectiveAction;
use Illuminate\Http\Request;

class CorrectiveActionController extends Controller
{

    public function index()
    {
        $corrective = CorrectiveAction::all();

        return $corrective;
    }

    public function create(Request $request)
    {
       $corrective = new CorrectiveAction;
       $corrective->corrective_action = $request->corrective_action;
       $corrective->save();

       return $corrective;
    }

    public function show(int $id, Request $request)
    {
        $corrective = CorrectiveAction::updateOrCreate(['id' => $id], $request->all());

        return $corrective;
    }

    public function edit(int $id)
    {        
        $corrective = CorrectiveAction::all()->where('id', $id)->first();

        return $corrective;
    }

    public function destroy(int $id)
    {
        $corrective = CorrectiveAction::findOrFail($id)->delete();

        return response()->json($corrective);
    }

    public function dropdown()
    {
        $provision = CorrectiveAction::select('id as value','corrective_action as text')->get();

        return response()->json($provision);
    }
    
}
