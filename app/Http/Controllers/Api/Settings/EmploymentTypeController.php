<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Vps\EmploymentType;
use Illuminate\Http\Request;


class EmploymentTypeController extends Controller
{
    public function index()
    {
        $employment = EmploymentType::all();
        return response()->json($employment);
    }

    public function create(Request $request)
    {
        $employment = new EmploymentType;
        $employment->name = $request->name;
        $employment->Description = $request->description;
        $employment->save();
        return $employment;
    }

    public function show(int $id, Request $request)
    {
        $employment = EmploymentType::updateOrCreate(['id' => $id], $request->all());
        return $employment;
    }

    public function edit(int $id)
    {
        $employment = EmploymentType::all()->where('id', $id)->first();
        return $employment;
    }

    public function destroy(int $id)
    {
        $employment = EmploymentType::findOrFail($id)->delete();
        return response()->json($employment);
    }

    public function dropdown()
    {
        $employment = EmploymentType::select('id as value','name as text')->get();
        return response()->json($employment);
    }
}
