<?php

namespace App\Http\Controllers\Api\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\GravityOffense;
use App\Models\HR\Gravity;
use Illuminate\Http\Request;

class GravityController extends Controller
{

    public function index()
    {
        $gravity = GravityOffense::with(['gravity'])->get();

        return $gravity;
    }

    public function create(Request $request)
    {
       $gravity = new GravityOffense;
       $gravity->fields = $request->fields;
       $gravity->gravity_id = $request->gravity_id;
       $gravity->description = $request->description;
       $gravity->save();

       return $gravity;
    }

    public function show(int $id, Request $request)
    {
        $gravity = GravityOffense::updateOrCreate(['id' => $id], $request->all());

        return $gravity;
    
    }

    public function edit(int $id)
    {
        $gravity = GravityOffense::all()->where('id', $id)->first();

        return $gravity;
    }

    public function destroy(int $id)
    {
        $gravity = GravityOffense::findOrFail($id)->delete();

        return response()->json($gravity);
    }

    public function dropdown()
    {
        $gravity = Gravity::select('id as value','gravity as text')->get();
        
        return response()->json($gravity);
    }

}
