<?php

namespace App\Http\Controllers;

use App\Models\Scripts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator, Input, Image, Carbon\Carbon, File, Storage;
use Illuminate\Support\Facades\DB;


class ScriptsController extends Controller
{
    
    public function index()
    {
        // $scripts = Scripts::all();
        $scripts = Scripts::leftJoin('db_vps.users as u1', 'created_by','=','db_vps.u1.id')
        ->leftJoin('db_vps.users as u2', 'updated_by','=','db_vps.u2.id')
        ->select('scripts.*', 
            DB::raw('CONCAT(u1.first_name, " ", u1.last_name) AS created_name'),
            DB::raw('CONCAT(u2.first_name, " ", u2.last_name) AS updated_name'))
        ->get();

        return response()->json($scripts);
    }
    
    public function create(Request $request)
    {        
        $scripts = new Scripts();
        $scripts->title = $request->title;
        $scripts->scripts = $request->scripts;
        $scripts->created_by = Auth::user()->id;
        $scripts->updated_by = Auth::user()->id;
        $scripts->save();

        return $scripts;
    }

    public function show($id, Request $request)
    {
        $scripts = Scripts::updateOrCreate(['id' => $id], $request->all());

        return $scripts;
    }

    public function edit($id)
    {
        $scripts = Scripts::all()->where('id', $id)->first();

        return $scripts;
    }
    
    public function update(Request $request, $id)
    {
        $scripts = Scripts::findOrFail($id)->delete();

        return response()->json($scripts);
    }

    public function scriptTags(Request $request)
    {
        $storage = Storage::put('/vps/images/script_tags', $request->file('image'), 'public');
        $url = Storage::url($storage);
        
        return $url;
    }

    public function dropdown()
    {
        $script = Scripts::select('id as value','title as text')->get();
        return response()->json($script);
    }

    public function getScripts(int $id) 
    {
        $script = Scripts::where('id', $id)->get();

        return response()->json($script);
    }

    public function getUserScripts() 
    {
        $script = Scripts::leftJoin('db_vps.users as u1', 'created_by','=','db_vps.u1.id')
        ->leftJoin('db_vps.users as u2', 'updated_by','=','db_vps.u2.id')
        ->select('scripts.*', 
            DB::raw('CONCAT(u1.first_name, " ", u1.last_name) AS created_name'),
            DB::raw('CONCAT(u2.first_name, " ", u2.last_name) AS updated_name'))
//        ->where('created_by', Auth::user()->id)
        ->get();

        return response()->json($script);
    }

}
