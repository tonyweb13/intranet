<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\AdjFees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdjFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adj = AdjFees::all();
        return response()->json($adj);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $adj = new AdjFees();
        $adj->portfolio = $request->portfolio;
        $adj->loan_id = $request->loan_id;
        $adj->submitted_by = Auth::user()->first_name .' '. Auth::user()->last_name;
        $adj->save();

        return $adj;
    }

    public function show(int $id, Request $request)
    {
        $adj = AdjFees::updateOrCreate(['id' => $id], $request->all());

        return $adj;
    }

    public function edit(int $id)
    {
       $adj = AdjFees::all()->where('id', $id)->first();

       return $adj;
    }

    public function destroy(int $id)
    {
        $adj = AdjFees::findOrFail($id)->delete();

        return response()->json($adj);
    }
}
