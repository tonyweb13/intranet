<?php

namespace App\Providers;

use App\Models\LoanApproval\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanApplicationProcessProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
//        dd($request->apps);
////        dd($request->loan_id);
        Application::created(function ($application) {
            DB::connection('loan')->table('application_process')->insert(
                [
                   'action'         => 'new'
                 , 'application_id' => $application->id
                 , 'status'         => 1
                 , 'user_id'        => Auth::id()
                 , 'description'    => json_encode($application)
                 , 'created_at'     => Carbon::now()
                 , 'updated_at'     => Carbon::now()
                ]
            );
        });

        Application::updated(function ($application) {
//            dd($application);
            DB::connection('loan')->table('application_process')->insert(
                [
                    'action'         => 'update'
                    , 'application_id' => $application->id
                    , 'status'         => (isset($application->status)) ? $application->status : 1
                    , 'user_id'        => Auth::id()
                    , 'description'    => json_encode($application)
                    , 'created_at'     => Carbon::now()
                    , 'updated_at'     => Carbon::now()
                ]
            );
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
