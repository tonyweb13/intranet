<?php

namespace App\Http\Controllers\Api\LoanApproval;

use App\Http\Controllers\Controller;
use App\Models\LoanApproval\DCInfo;
use App\Encrypterdecrypter\CreditCardEncryptFacade as CreditCrypt;
use App\Encrypterdecrypter\SalarEncyptFacade as Wew;
use Illuminate\Http\Request;

class DCInfoController extends Controller
{

    public function index()
    {
        $dcinfo = DCInfo::getDc();

        return $dcinfo;
    }

    public function create(Request $request)
    {
        $test = DCInfo::setDc($request);

        return $test;
    }

    public function show(int $id, Request $request)
    {
        $dcinfo = DCInfo::updateOrCreate(['id' => $id], $request->all());

        return $dcinfo;
    }

    public function edit(int $id)
    {
        $dcinfo = DCInfo::all()->where('id', $id)->first();

        return $dcinfo;
    }

    public function destroy(int $id)
    {
        $dcinfo = DCInfo::findOrFail($id)->delete();

        return response()->json($dcinfo);
    }

}
