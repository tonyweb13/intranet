<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PasswordHistory extends Model
{
    protected $table = 'password_history';

    protected $fillable = ['employee_no', 'old_password', 'new_password'];

    public static function createPasswordHistory($request)
    {      
        $retrieve_old = User::select('password')->where('id', Auth::user()->id)->first();

        $passHistory = new PasswordHistory;
        $passHistory->employee_no = $request->employee_no;
        $passHistory->old_password = $retrieve_old->password;
        $passHistory->new_password = MD5($request->password);
        $passHistory->save();
        return $passHistory;
    }

}
