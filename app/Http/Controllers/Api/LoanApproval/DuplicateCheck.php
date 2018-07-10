<?php

namespace App\Http\Controllers\API\LoanApproval;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


class DuplicateCheck extends Controller
{
    public function checkPortfolios(Request $request)
    {

//        $fields = json_decode($request->fields);
//        $message = 'test';
//        echo $messages;
//        Log::emergency($message);
////        Log::alert($message);
////        Log::critical($message);
////        Log::error($message);
////        Log::warning($message);
////        Log::notice($message);
////        Log::info($message);
////        Log::debug($message);
////        return;
//
//        } catch (Exception $e) {
//
//        }

        switch ($request->check) {
            case 'INBX' :
                return response()->json(self::portfolioInbx($request));
                break;
            case 'SOF' :
                return response()->json(self::portfolioSOF($request));
                break;
            case 'COMET' :
                return response()->json(self::portfolioCOMET($request));
                break;
            case 'IBC' :
                return response()->json(self::portfolioIBC($request));
                break;
        }

    }

    private static function portfolioInbx($request)
    {
        try {

            $fields = json_decode($request->fields);

            $result = DB::connection('aws_sql_db')->table(DB::raw('[INBX].[EpicLoan_117S].[dbo].[vw_Client] AS A'))
                ->select(DB::raw('A.Id As id, B.LoanStatus As status, B.EffectiveDate as effective_date, A.FirstName as first_name, A.LastName as last_name, A.EmailAddress as email, A.SSN as ssn, A.CustomerAccount as customer_account'))
                ->leftJoin(DB::raw('[INBX].[EpicLoan_117S].[dbo].[vw_Loans] AS B'), 'A.ID', '=', 'B.DebtorClientId');

            if(!empty($fields->ssn_no)) {
                $result->where('A.SSN', $fields->ssn_no);
            }

            if(!empty($fields->bank_account_no)) {
                $result->where('A.CustomerAccount', $fields->bank_account_no);
            }

            if(!empty($fields->email)) {
                $result->where('A.EmailAddress', $fields->email);
            }

            if(!empty($fields->fname)) {
                $result->where('A.FirstName', $fields->fname);
            }

            if(!empty($fields->lname)) {
                $result->where('A.LastName', $fields->lname);
            }

            $error = false;
            $msg   = $result->get()->first();

        } catch (Exception $e) {
            Log::alert('Unable to check duplicate on INBX API Error : '.$e);
            $error = true;
            $msg = 'Something went wrong unable to check duplicate on INBX API';
        }

        return ['error' => $error, 'msg' => $msg];
    }

    private static function portfolioSOF($request)
    {

        try {
            $fields = json_decode($request->fields);

            $result = DB::connection('aws_sql_db')->table(DB::raw('[DB_SOF].[dbo].[Tbl_Client] AS A'))
                ->select(DB::raw('A.Id As id, B.LoanStatus As status, B.EffectiveDate as effective_date, A.FirstName as first_name, A.LastName as last_name, A.EmailAddress as email, A.SSN as ssn, A.CustomerAccount as customer_account'))
                ->leftJoin(DB::raw('[DB_SOF].[dbo].[Tbl_Loans] AS B'), 'A.ID', '=', 'B.DebtorClientId');

            if(!empty($fields->ssn_no)) {
                $result->where('A.SSN', $fields->ssn_no);
            }

            if(!empty($fields->bank_account_no)) {
                $result->where('A.CustomerAccount', $fields->bank_account_no);
            }

            if(!empty($fields->email)) {
                $result->where('A.EmailAddress', $fields->email);
            }

            if(!empty($fields->fname)) {
                $result->where('A.FirstName', $fields->fname);
            }

            if(!empty($fields->lname)) {
                $result->where('A.LastName', $fields->lname);
            }

            $error = false;
            $msg   = $result->get()->first();

        } catch (Exception $e) {
            Log::alert('Unable to check duplicate on INBX API Error : '.$e);
            $error = true;
            $msg = 'Something went wrong unable to check duplicate on INBX API';
        }

        return ['error' => $error, 'msg' => $msg];
    }

    private static function portfolioIBC($request)
    {
        try {

            $fields = json_decode($request->fields);
            $result = DB::connection('ibc')
                ->table(DB::raw('inbox_credit_prod.leads As A'))
                ->select(DB::raw('A.loan_number as id,B.description as status, A.created_at as effective_date, A.first_name as first_name, A.last_name as last_name, A.email_address, A.ssn, A.bank_account_number as customer_account'))
                ->leftJoin(DB::raw('inbox_credit_prod.lead_statuses As B'), 'A.lead_status_id', '=', 'B.id');

            if(!empty($fields->ssn_no)) {
                $result->where('A.ssn', $fields->ssn_no);
            }

            if(!empty($fields->bank_account_no)) {
                $result->where('A.bank_account_number', $fields->bank_account_no);
            }

            if(!empty($fields->email)) {
                $result->where('A.email_address', $fields->email);
            }

            if(!empty($fields->fname)) {
                $result->where('A.first_name', $fields->fname);
            }

            if(!empty($fields->lname)) {
                $result->where('A.last_name', $fields->lname);
            }

            $result->orderBy('A.created_at', 'desc');

            $error = false;
            $msg   = $result->get()->first();

        } catch (Exception $e) {
            Log::alert('Unable to check duplicate on IBC LMS Error : '.$e);
            $error = true;
            $msg = 'Something went wrong unable to check duplicate on IBC LMS';
        }

        return ['error' => $error, 'msg' => $msg];

    }

    private static function portfolioCOMET($request)
    {

        try {

            $fields = json_decode($request->fields);
            $result = DB::connection('comet')
                ->table(DB::raw('comet_prod.leads As A'))
                ->select(DB::raw('A.loan_number as id,B.description as status, A.created_at as effective_date, A.first_name as first_name, A.last_name as last_name, A.email_address, A.ssn, A.bank_account_number as customer_account'))
                ->leftJoin(DB::raw('comet_prod.lead_statuses As B'), 'A.lead_status_id', '=', 'B.id');

            if(!empty($fields->ssn_no)) {
                $result->where('A.ssn', $fields->ssn_no);
            }

            if(!empty($fields->bank_account_no)) {
                $result->where('A.bank_account_number', $fields->bank_account_no);
            }

            if(!empty($fields->email)) {
                $result->where('A.email_address', $fields->email);
            }

            if(!empty($fields->fname)) {
                $result->where('A.first_name', $fields->fname);
            }

            if(!empty($fields->lname)) {
                $result->where('A.last_name', $fields->lname);
            }

            $result->orderBy('A.created_at', 'desc');

            $error = false;
            $msg   = $result->get()->first();

        } catch (Exception $e) {
            Log::alert('Unable to check duplicate on COMET LMS Error : '.$e);
            $error = true;
            $msg = 'Something went wrong unable to check duplicate on COMET LMS';
        }

        return ['error' => $error, 'msg' => $msg];
    }




    /* Epic API unable to get most recent status*/
    private function checkInbox( $request )
    {
        try  {

            /* Build APi params for inbox */
            $api_params = [];
            if (!empty($request->ssn_no)) {
                array_push($api_params,'ssn='.trim(str_replace('-','', preg_replace('/[^A-Za-z0-9\-]/', '', $request->ssn_no))));
            }

            if (!empty($request->bank_account_no)) {
                array_push($api_params,'bankAccountNumber='.trim($request->bank_account_no));
            }

            if (!empty($request->email)) {
                array_push($api_params,'emailAddress='.trim($request->email));
            }

            if (!empty($request->fname)) {
                array_push($api_params,'firstName='.trim($request->fname));
            }

            if (!empty($request->lname)) {
                array_push($api_params,'lastName='.trim($request->lname));
            }

            $i = 0;
            $params_build = '';
            foreach ($api_params as $params) {
                if($i == 0) {
                    $params_build .= '?'.$params;
                } else {
                    $params_build .= '&'.$params;
                }
                $i++;
            }

            $auth = config('epicapi.'.$request->portfolio);
            $client = new Client();
            $res = $client->request('GET', config('epicapi.url').'/token', [
                'auth' => [$auth['prod']['Acceskey'], $auth['prod']['Secretkey']]
            ]);

            $auth_key = json_decode($res->getBody());

            $clients = new Client();
            $ress = $clients->request('GET', config('epicapi.url').'customers'.$params_build, [
                'headers' => [
                    'Authorization' => 'Token '.$auth_key->accessToken,
                    'Accept'     => 'application/json',
                ]
            ]);

           $result = json_decode($ress->getBody());

//           print_r($result);

           $loop_identity = 0;
           foreach ($result->items as $data) {
//                echo $data->customerId;
               $cl = new Client();
               $ress = $cl->request('GET', config('epicapi.url').'customers/'.$data->customerId.'/loans', [
                   'headers' => [
                       'Authorization' => 'Token '.$auth_key->accessToken,
                       'Accept'     => 'application/json',
                   ]
               ]);

               $cl = '';
               print_r(json_decode($ress->getBody()));

           }

//           print_r($result);

//            return $ress->getBody();


        } catch (\Exception $e) {
            $response['error'] = 1;
            $response['message'] = $e->getMessage();
        }

    }
    private static function epicStatusCodes ($status_code)
    {
        switch  ($status_code) {
            case 0:
                return 'Created';
                break;
            case 2:
                return 'PendingApplication';
                break;
            case 3:
                return 'Denied';
                break;
            case 4:
                return 'WithdrawnApplication';
                break;
            case 6:
                return 'VoidedNewLoan';
                break;
            case 8:
                return 'VoidedRenewedLoan';
                break;
            case 10:
                return 'NewLoan';
                break;
            case 12:
                return 'RenewedLoan';
                break;
            case 16:
                return 'ChargedOff';
                break;
            case 18:
                return 'PaidOffLoan';
                break;
            case 20:
                return 'PendingPaidOff';
                break;
            case 22:
                return 'RenewedLoanPaidOff';
                break;
            case 24:
                return 'RenewedLoanPendingPaidOff';
                break;
            case 26:
                return 'ReturnedItemPaidOff';
                break;
            case 28:
                return 'ChargedOffPaidOff';
                break;
            case 30:
                return 'ReturnedItemPendingPaidOff';
                break;
            case 32:
                return 'ChargedOffPendingPaidOff';
                break;
            case 34:
                return 'SettlementPaidOff';
                break;
            case 36:
                return 'PendingRenewalLoan';
                break;
            case 37:
                return 'ReturnedItem';
                break;
            case 38:
                return 'PendingCollection';
                break;

    }



    }
}
