<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;
use App\Models\user;
use Carbon\Carbon;

class ApplicationProcess extends Model
{
    //    use Notifiable;
    protected $table = 'application_process';

    protected $connection = 'loan';
//
    protected $appends = ["full_name"];


    public function getFullNameAttribute()
    {
        $user = user::find($this->user_id)->first();
        return "{$user->first_name} {$user->last_name}";
    }

    public function ApplicationId()
    {
        return $this->hasOne(Application::class, 'application_id','id');
    }

    public static function addApplicationProcess( $action, $application_id, $status, $user_id , $description )
    {
        /* Add Application Process Status to Pending */
        $app_process= new ApplicationProcess;
        $app_process->action         = $action;
        $app_process->application_id = $application_id;
        $app_process->status         = $status;
        $app_process->user_id        = $user_id;
        $app_process->description    = $description;
        $app_process->created_at     = Carbon::now();
        $app_process->updated_at     = Carbon::now();
        $app_process->save();
    }
}
