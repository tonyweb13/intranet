<?php

namespace App\Http\Controllers;

use App\Models\Countries;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Countries::all();
        return response()->json($countries);

    }
}
