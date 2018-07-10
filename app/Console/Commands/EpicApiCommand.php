<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class EpicApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EpicApi:Test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try  {
            $portfolio = config('epicapi.portfolio');
            $auth = config('epicapi.'.$portfolio);
            $client = new Client();
            $res = $client->request('GET', config('epicapi.url').'/token', [
                'auth' => [$auth['prod']['Acceskey'], $auth['prod']['Secretkey']]
            ]);

            $response = json_decode($res->getBody());

            echo $response->accessToken;

        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            exit;
        }
    }
}
