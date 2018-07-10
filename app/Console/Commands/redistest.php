<?php

namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Filter;
use App\Logger\Facades\Logger;
use App\Models\BadAba;



class redistest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Redis Codes';

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
        // Redis::set('name', 'Taylor');

        //print_r(Redis::lrange('names', 0, 10));

        // print_r(Redis::get('key:0'));
        
        Redis::pipeline(function ($pipe) {
            $aba_failed =  BadABA::all();
            foreach($aba_failed as $idex=>$field) {
                $pipe->hmset("badaba:".$idex,  'id', $field->id, 'aba', $field->name);
                $pipe->set('badaba:aba:'.$field->name, $idex);
                $pipe->zadd('badaba:created_at', time(), $idex);
            }
            // for ($i = 0; $i < 10; $i++) {
            //     $pipe->set("names:$i", $i);
            // }
        });

        // echo Redis::get('badaba:aba:010469547');

        $aba_id = Redis::get('badaba:aba:010469547');
        echo $aba_id ;
        $user    = Redis::hmget('badaba:'.$aba_id, 'id', 'aba');
        print_r($user);
         
        //  Redis::rpush('lead_gen_queue_tmp', $aba_failed);
        // print_r($aba_failed);
        // $user_id = Redis::incr('user:id');
        // Redis::hmset('user:' . $user_id,'username', 'josh', 'about', 'i love to code');
        // $user_id = Redis::incr('user:id');
        // Redis::hmset('user:' . $user_id,'username', 'jen', 'about', 'i love to read');
        // $user_id = Redis::incr('user:id');
        // Redis::hmset('user:' . $user_id,'username', 'lizzy', 'about', 'i love to dance');

        print_r(Redis::get('name'));

     
    }
}
