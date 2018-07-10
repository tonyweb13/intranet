<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Vps\OfficeLocation;
use Illuminate\Http\Request;


class OfficeLocationController extends Controller
{
    public function index()
    {
        $officelocation = OfficeLocation::all();
        return response()->json($officelocation);
    }

    public function create(Request $request)
    {
        $officelocation = new OfficeLocation;
        $officelocation->name = $request->name;
        $officelocation->description = $request->description;
        $officelocation->save();
        return $officelocation;
    }

    public function show(int $id, Request $request)
    {
        $officelocation = OfficeLocation::updateOrCreate(['id' => $id], $request->all());
        return $officelocation;
    }

    public function edit(int $id)
    {
        $officelocation = OfficeLocation::all()->where('id', $id)->first();
        return $officelocation;
    }

    public function destroy(int $id)
    {
        $officelocation = OfficeLocation::findOrFail($id)->delete();
        return response()->json($officelocation);
    }

    public function dropdown()
    {
        $officelocation = OfficeLocation::select('id as value','name as text')->get();
        return response()->json($officelocation);
    }
}
