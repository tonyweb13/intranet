<?php

namespace App\Models\LoanApproval;

use Illuminate\Database\Eloquent\Model;
//use App\Events\LoanApproval\Saved;
//use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Vps\ {
    Users,
    UsersGroups,
    Portfolio
};


class Application extends Model
{
//    use Notifiable;
    protected $table = 'applications';

    protected $connection = 'loan';

    protected $fillable = ['app_number', 'states', 'portfolio', 'downloads', 'new_or_return', 'end_of_billing', 'pay_type', 'exceptions'];

    protected $appends = ['group_date','originator_name',  'underwriter_name', 'tribe_name'];
//    protected $appends = ['group_date'];

    public function getGroupDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['created_at'])->format('F-d-Y');
    }

    public function getOriginatorNameAttribute()
    {
        $user = Users::where('id', $this->attributes['originator'])->first();

        return (!empty($user)) ? $user->first_name. ' '.$user->last_name : null;
    }

    public function getUnderwriterNameAttribute()
    {
        $user = Users::where('id', $this->attributes['underwriter'] ?? null)->first();
        return (!empty($user)) ? $user->first_name. ' '.$user->last_name : null;
    }

    public function getTribeNameAttribute()
    {
        $user = Users::where('id', $this->attributes['tribe'] ?? null)->first();
        return (!empty($user)) ? $user->first_name. ' '.$user->last_name : null;
    }

//    public function orignatorsName()
//    {
//        $users = new Users;
//        $this->setConnection('vps');
//        return $this->hasOne($users, 'id', 'originator');
//    }

//    public function getSsnAttribute()
//    {
//        return $this->attributes['ssn'], -4);;
//    }

    public function portfolioRelation()
    {
        return $this->hasOne(Portfolio::class, 'name','portfolio');
    }


    public function notes()
    {
        return $this->hasMany(Notes::class);
    }

    public function ApplicationProcess()
    {
        return $this->hasMany(ApplicationProcess::class, 'application_id', 'id');
    }

    /* Transfer to Service Provider Listener */
//    protected static function boot()
//    {
//        parent::boot();
//
//        static::created(function ($application) {
//            DB::connection('loan')->table('application_process')->insert(
//                [
//                    'action'         => 'new'
//                    , 'application_id' => $application->id
//                    , 'status'         => 1
//                    , 'user_id'        => Auth::id()
//                    , 'description'    => json_encode($_REQUEST)
//                    , 'created_at'     => Carbon::now()
//                    , 'updated_at'     => Carbon::now()
//                ]
//            );
//        });
//
//        static::updated(function ($application) {
//            DB::connection('loan')->table('application_process')->insert(
//                [
//                    'action'         => 'update'
//                    , 'application_id' => $application->id
//                    , 'status'         => 1
//                    , 'user_id'        => Auth::id()
//                    , 'description'    => json_encode($_REQUEST)
//                    , 'created_at'     => Carbon::now()
//                    , 'updated_at'     => Carbon::now()
//                ]
//            );
//        });
//    }



}