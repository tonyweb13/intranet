<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\Correction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CorrectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $correction = Correction::leftJoin('corrections as corr2', 'corrections.parent_correction_id', '=', 'corr2.id')
            ->select('corrections.id', 'corrections.correction_name', 'corrections.parent_correction_id', 'corrections.code', 'corrections.description',
                DB::raw("(CASE WHEN (corr2.correction_name = NULL) THEN '' ELSE corr2.correction_name END) as corr_parent"))
            ->orderBy('id')
            ->get();

        return response()->json($correction);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $correction = new Correction();
        $correction->correction_name = $request->correction_name;
        $correction->parent_correction_id = $request->parent_correction_id;
        $correction->code = $request->code;
        $correction->description = $request->correction;
        $correction->save();

        return $correction;
    }

    public function show(int $id, Request $request)
    {
        $correction = Correction::updateOrCreate(['id' => $id], $request->all());

        return $correction;
    }

    public function edit(int $id)
    {
       $correction = Correction::all()->where('id', $id)->first();

       return $correction;
    }

    public function destroy(int $id)
    {
        $correction = Correction::findOrFail($id)->delete();

        return response()->json($correction);
    }

    public function dropdown()
    {
        $correction = Correction::select('id as value', 'correction_name as text')->get();
        return response()->json($correction);
    }
}
