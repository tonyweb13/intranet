<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\BadABA;
use Illuminate\Http\Request;

class BadABAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aba = BadABA::all();
        
        return response()->json($aba);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $aba = new BadABA();
        $aba->aba_number = $request->aba_number;
        $aba->reason = $request->reason;
        $states->save();

        return $states;
    }

    public function show(int $id, Request $request)
    {
        $aba = BadABA::updateOrCreate(['id' => $id], $request->all());

        return $aba;
    }

    public function edit(int $id)
    {
       $aba = BadABA::all()->where('id', $id)->first();

       return $aba;
    }

    public function destroy(int $id)
    {
        $aba = BadABA::findOrFail($id)->delete();

        return response()->json($aba);
    }
}
