<?php

namespace App\Http\Controllers\Api\HR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HR\Offense;

class OffenseController extends Controller
{
    public function index()
    {
        $offense = Offense::with(['category', 'provision', 'gravity', 'corrective_action'])->get();

        return $offense;
    }

    public function create(Request $request)
    {
       $offense = new Offense;
       $offense->category_id = $request->category_id;
       $offense->provision_id = $request->provision_id;
       $offense->gravity_id = $request->gravity_id;
       $offense->corrective_action_id = $request->corrective_action_id;
       $offense->offense = $request->offense;
       $offense->save();

       return $offense;
    }

    public function show(int $id, Request $request)
    {
        $offense = Offense::with(['category', 'provision', 'gravity', 'corrective_action'])->updateOrCreate(['id' => $id], $request->all());

        return $offense;
    }

    public function edit(int $id)
    {        
        $offense = Offense::all()->where('id', $id)->first();

        return $offense;
    }

    public function destroy(int $id)
    {
        $offense = Offense::findOrFail($id)->delete();

        return response()->json($offense);
    }

    public function category(int $catid)
    {
        $offense = Offense::with(['category', 'provision', 'gravity', 'corrective_action'])
        ->where('category_id', $catid)
        ->get();

        return $offense;
    }
}
