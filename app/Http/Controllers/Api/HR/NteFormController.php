<?php

namespace App\Http\Controllers\Api\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\NteFormList;
use Illuminate\Http\Request;

class NteFormController extends Controller
{

    public function index()
    {
        $ntelist = NteFormList::all();

        return response()->json($ntelist);
    }

    public function create(Request $request)
    {
        $ntelist = new NteFormList;
        $ntelist->name = $request->name;
        $ntelist->description = $request->description;
        $ntelist->save();
        
        return $ntelist;
    }

    public function show(int $id, Request $request)
    {
        $nte = NteFormList::updateOrCreate(['id' => $id], $request->all());

        return $nte;
    
    }

    public function edit(int $id)
    {
        $nte = NteFormList::all()->where('id', $id)->first();

        return $nte;
    }

    public function destroy(int $id)
    {
        $nte = NteFormList::findOrFail($id);
        $nte->delete();

        return response()->json($nte);
    }

    public function dropdown()
    {
        $nte = NteFormList::select('id as value','name as text')->get();
        return response()->json($nte);
    }

    public function getInfo(int $id)
    {
        $ntelist = NteFormList::where('id', $id)->get();

        return response()->json($ntelist);
    }

}
