<?php

namespace App\Http\Controllers\Api\QualityAssurance;

use App\Console\Commands\redistest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function setMonth(Request $request)
    {
        if ($request->input('month') || $request->input('month') !== null) {
            session(['month' => $request->input('month')]);
        } else {
            session(['month' => date('m')]);
        }

        $month = $request->session()->get('month');

        return response()->json($month);
    }

    public function getMonth(Request $request)
    {
        if (!$request->session()->has('month')) {
            session(['month' => $request->input('month')]);
        }

        $month = $request->session()->get('month');

        return response()->json($month);
    }
}
