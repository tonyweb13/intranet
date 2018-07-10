<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Vps\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        $department = Department::all();
        return response()->json($department);
    }

    public function create(Request $request)
    {
        $department = new Department;
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();
        return $department;
    }

    public function show(int $id, Request $request)
    {
        $department = Department::updateOrCreate(['id' => $id], $request->all());
        return $department;
    }

    public function edit(int $id)
    {
        $department = Department::all()->where('id', $id)->first();
        return $department;
    }

    public function destroy(int $id)
    {
        $department = Department::findOrFail($id)->delete();
        return response()->json($department);
    }

    public function dropdown()
    {
        $department = Department::select('id as value','name as text')->get();
        return response()->json($department);
    }
}
