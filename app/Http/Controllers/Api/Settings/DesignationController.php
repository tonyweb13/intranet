<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Vps\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{

    public function index()
    {
//        $designation = Designation::paginate(10);
        $designation = Designation::all();
        return response()->json($designation);
    }

    public function create(Request $request)
    {
        $designation = new Designation;
        $designation->name = $request->name;
        $designation->save();
        return $designation;
    }

    public function show(int $id, Request $request)
    {
        $designation = Designation::updateOrCreate(['id' => $id], $request->all());
        return $designation;
    }

    public function edit(int $id)
    {
        $designation = Designation::all()->where('id', $id)->first();
        return $designation;
    }

    public function destroy(int $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();
        return response()->json($designation);
    }

    public function dropdown()
    {
        $designation = Designation::select('id as value','name as text')->get();
        return response()->json($designation);
    }
}
