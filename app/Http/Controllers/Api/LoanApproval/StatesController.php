<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\States;
use Illuminate\Http\Request;

class StatesController extends Controller
{

    public function index()
    {
        $states = States::all();
        
        return response()->json($states);
    }

    public function create(request $request)
    {
        $states = new States();
        $states->name = $request->name;
        $states->code = $request->code;
        $states->rate = $request->rate;
        $states->description = $request->description;
        $states->save();

        return $states;
    }

    public function show(int $id, Request $request)
    {
        $states = States::updateOrCreate(['id' => $id], $request->all());

        return $states;
    }

    public function getLoanStates(Request $request)
    {
        $states = States::all()->where('code', $request->state)->first();

        return response()->json($states);;
    }

    public function edit(int $id)
    {
       $states = States::all()->where('id', $id)->first();

       return $states;
    }

    public function destroy(int $id)
    {
        $states = States::findOrFail($id)->delete();

        return response()->json($states);
    }

}