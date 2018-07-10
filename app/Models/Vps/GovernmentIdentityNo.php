<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class GovernmentIdentityNo extends Model
{
    protected $table = 'government_identity_no';

    public  static function importIndentityNo( int $user_id, $identity ) : int
    {
        $replace = array('-',' ');
        $identity_id= new GovernmentIdentityNo;
        $identity_id->phil_health_number = str_replace($replace, "", $identity->philhealth);
        $identity_id->hmdf_number =  str_replace($replace, "",$identity->hdmf);
        $identity_id->sss_number = str_replace($replace, "",$identity->sss);
        $identity_id->tin_number = str_replace($replace, "",$identity->tin);
        $identity_id->save();

        return $identity_id->id;
    }

}
