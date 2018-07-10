<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Vps\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{

    public function index()
    {
        $portfolio = Portfolio::all();
        return response()->json($portfolio);
    }

    public function create(Request $request)
    {
        $portfolio = new Portfolio;
        $portfolio->name = $request->name;
        $portfolio->description = $request->description;
        $portfolio->save();
        return $portfolio;
    }

    public function show(int $id, Request $request)
    {
        $portfolio = Portfolio::updateOrCreate(['id' => $id], $request->all());
        return $portfolio;
    }

    public function edit(int $id)
    {
        $portfolio = Portfolio::all()->where('id', $id)->first();
        return $portfolio;
    }

    public function destroy(int $id)
    {
        $portfolio = Portfolio::findOrFail($id)->delete();
        return response()->json($portfolio);
    }

    public function dropdown()
    {
        $portfolio = Portfolio::select('id as value','name as text')->get();
        return response()->json($portfolio);
    }
}
