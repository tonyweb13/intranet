<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class EpicApiController extends Controller
{
    private $auth_key = '';

    public function __construct(Request $request)
    {

        try  {

            $auth = config('epicapi.'.$request->portfolio);
            $client = new Client();
            $res = $client->request('GET', config('epicapi.url').'/token', [
                'auth' => [$auth['prod']['Acceskey'], $auth['prod']['Secretkey']]
            ]);

            $response  = $res->getBody();
            $this->auth_key = json_decode($res->getBody());

        } catch (\Exception $e) {
            $response['error'] = 1;
            $response['message'] = $e->getMessage();
        }

    }

    public function index(Request $request)
    {
        echo $this->auth_key->accessToken;
    }

    public function loans(Request $request)
    {
            $auth = config('epicapi.'.$request->portfolio);
            $client = new Client();
            $res = $client->request('GET', config('epicapi.url').'Loans/?displayNumber='.$request->app_no, [
                'headers' => [
                    'Authorization' => 'Token '.$this->auth_key->accessToken,
                    'Accept'     => 'application/json',
                ]
            ]);

            return $res->getBody();

    }

    public function verifyCustomer(Request $request)
    {

        try {

            $loan_result= json_decode($this->loans($request));
            $auth = config('epicapi.'.$request->portfolio);
            $client = new Client();

            $res = $client->request('GET', config('epicapi.url').'customers/'.$loan_result->items[0]->customerId, [
                'headers' => [
                    'Authorization' => 'Token '.$this->auth_key->accessToken,
                    'Accept'     => 'application/json',
                ]
            ]);

            return $res->getBody();

        } catch (\Exception $e) {
            $response['error'] = 1;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function config(Request $request)
    {
            $auth = config('epicapi.'.$request->portfolio);
            $client = new Client();
            $res = $client->request('GET', config('epicapi.url').'config/badRoutingNumbers/?offset=1&rows=10', [
                'headers' => [
                    'Authorization' => 'Token '.$this->auth_key->accessToken,
                    'Accept'     => 'application/json',
                ]
            ]);

            $response  = json_decode($res->getBody());
            print_r($response);

    }

}
