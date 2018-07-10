<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LmsApiController extends Controller
{

    public function verifyCustomer(Request $request)
    {
        try {

            $customer = DB::connection(strtolower($request->portfolio))
                ->table('leads')
                ->join('addresses', 'leads.client_address_id', '=', 'addresses.id')
                ->select('leads.first_name as firstName','leads.last_name as lastName','addresses.state','leads.ssn', 'leads.email_address as emailAddress')
                ->where('leads.loan_number', $request->app_no)->first();

            if ( !empty($customer) )
            {
                return response()->json($customer);

            } else {
                $response['error'] = 1;
                $response['message'] = 'Undefined App ID';
                return $response;
            }

        } catch (Exception $e) {

            $response['error'] = 1;
            $response['message'] = $e->getMessage();

            return $response;
        }

    }

}
