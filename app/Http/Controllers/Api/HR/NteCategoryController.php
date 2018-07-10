<?php

namespace App\Http\Controllers\Api\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HR\NteCategory;

class NteCategoryController extends Controller
{

    public function index()
    {
        $category = NteCategory::all();
        return $category;
    }

    public function create(Request $request)
    {
       $category = new NteCategory;
       $category->name = $request->name;
       $category->description = $request->description;
       $category->save();

       return $category;
    }

    public function show(int $id, Request $request)
    {
        $category = NteCategory::updateOrCreate(['id' => $id], $request->all());

        return $category;
    
    }

    public function edit(int $id)
    {
        $category = NteCategory::all()->where('id', $id)->first();

        return $category;
    }

    public function destroy(int $id)
    {
        $category = NteCategory::findOrFail($id)->delete();
        
        return response()->json($category);
    }

    public function dropdown()
    {
        $category = NteCategory::select('id as value','name as text')->get();

        return response()->json($category);
    }

}
