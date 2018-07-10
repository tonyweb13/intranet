<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class DropdownController extends Controller
{

    public function requestedBy()
    {
        $requestedBy = User::select('id as value', DB::raw('CONCAT(first_name, " ", last_name) AS text'))
            ->where([['designation_id', '!=', 5], ['designation_id', '!=', 9]])->get();
        return response()->json($requestedBy);
    }

    public function assistant()
    {
        $assistant = User::select('id as value', DB::raw('CONCAT(first_name, " ", last_name) AS text'))->where('designation_id',56)->get();
        return response()->json($assistant);
    }

    public function supervisor()
    {
        $supervisor = User::select('id as value', DB::raw('CONCAT(first_name, " ", last_name) AS text'))->where('designation_id',33)->get();
        return response()->json($supervisor);
    }

}
