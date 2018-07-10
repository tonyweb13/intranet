<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Vps\CostCenter;
use Illuminate\Http\Request;


class CostCenterController extends Controller
{
    public function index()
    {
        $costcenter = CostCenter::all();
        return response()->json($costcenter);
    }

    public function create(Request $request)
    {
        $costcenter = new CostCenter;
        $costcenter->name = $request->name;
        $costcenter->description = $request->description;
        $costcenter->save();
        return $costcenter;
    }

    public function show(int $id, Request $request)
    {
        $costcenter = CostCenter::updateOrCreate(['id' => $id], $request->all());
        return $costcenter;
    }

    public function edit(int $id)
    {
        $costcenter = CostCenter::all()->where('id', $id)->first();
        return $costcenter;
    }

    public function destroy(int $id)
    {
        $costcenter = CostCenter::findOrFail($id)->delete();
        return response()->json($costcenter);
    }

    public function dropdown()
    {
        $costcenter = CostCenter::select('name as value','name as text')->get();
        return response()->json($costcenter);
    }
}
