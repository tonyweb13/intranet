<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Models\Vps\{
    Department,
    Designation,
    EmploymentType,
    Addresses,
    GovernmentIdentityNo,
    Rules,
    UsersGroups,
    PasswordHistory
};

class User extends Authenticatable
{
	protected $table = 'users';

    protected $fillable = ['username','password','first_name','last_name','middle_name',
    'email_address','birthday','gender','employee_no','tax_status_id','address_id',
    'civil_status','mobile_no','employment_type_id','work_location_id','date_hired',
    'regularization_date','department_id','cost_center_id','designation_id',
    'educational_institution','profile_pic','goverment_credential_id','remember_token',
    'is_default_password','is_active','course','year_graduated','bank_type','bank_account_no',
    'wave','person_to_contact_in_case_of_emergency','contact_person_no','relationship'];

    use HasApiTokens, Notifiable;

    protected $connection= 'vps';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ["full_name"];


    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function findForPassport($identifier) {
        return $this->where('employee_no', $identifier)->first();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function employment_type()
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function address()
    {
        return $this->belongsTo(Addresses::class);
    }

    public function government_credential()
    {
        return $this->belongsTo(GovernmentIdentityNo::class);
    }

    public function aclRules()
    {
        return $this->hasOne(Rules::class, 'user_id','id');
    }

    public function location()
    {
        return $this->hasOne(OfficeLocation::class, 'id','work_location_id');
    }

    public function members()
    {
        return $this->hasMany(UsersGroups::class, 'teamlead_employee_no', 'employee_no');
    }

    public function groupPortfolio() {
        return $this->hasOne(UsersGroups::class, 'employee_no','employee_no');
    }

    public function associatedAclPortfolio () : array
    {
        $get_user_details = $this::with('aclRules')->where('id', Auth::user()->id);
        $user_details = $get_user_details->first();


        $portfolio_rules = $user_details->aclRules->rules['portfolios']['is_enable'] ?? false;

        $new_portfolios = [];

        $result['errors'] = true;
        $result['msg'] =  'No associated portfolios assigned to your account';

        if ( $portfolio_rules ) {

            $portfolios = $user_details->aclRules->rules['portfolios']['child_rules'];

            foreach ($portfolios as $port => $value) {
                if($value) {
                    array_push($new_portfolios, $port);
                }
            }

            if(count($new_portfolios) >= 1) {
               return $new_portfolios;
            } else {
               return $result;
            }

        } else {

            return  $result;
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public static function setPassword($request) 
    {

        $user_id = $request->employee_no;
        $new_pass = User::where('employee_no', $user_id)->first();
        $new_pass->password = $request->password;
        if($request->is_default_password === 1){
            $new_pass->is_default_password = 0;
        } else {
            $new_pass->is_default_password = $request->is_default_password;
        }
        $new_pass->save();
        PasswordHistory::createPasswordHistory($request);

        return $new_pass;
    }
}
