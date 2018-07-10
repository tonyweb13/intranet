<?php

namespace App\Http\Controllers\Api\HR;

use App\Http\Controllers\Controller;
use App\Models\HR\Provision;
use Illuminate\Http\Request;

class ProvisionController extends Controller
{

    public function index()
    {
        $provision = Provision::with(['category'])->get();

        return $provision;
    }

    public function create(Request $request)
    {
       $provision = new Provision;
       $provision->provision = $request->provision;
       $provision->category_id = $request->category_id;
       $provision->save();

       return $provision;
    }

    public function show(int $id, Request $request)
    {
        $provision = Provision::updateOrCreate(['id' => $id], $request->all());

        return $provision;
    }

    public function edit(int $id)
    {        
        $provision = Provision::all()->where('id', $id)->first();

        return $provision;
    }

    public function destroy(int $id)
    {
        $provision = Provision::findOrFail($id)->delete();

        return response()->json($provision);
    }

    public function dropdown(int $catid)
    {
        $provision = Provision::select('id as value','provision as text')->where('category_id', '=', $catid)->get();

        return response()->json($provision);
    }
}
