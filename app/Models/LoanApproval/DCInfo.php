<?php

namespace App\Models\LoanApproval;

use App\Encrypterdecrypter\CreditCardEncryptFacade as CreditCrypt;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vps\Portfolio;

class DCInfo extends Model
{
    protected $connection = 'loan';

    protected $table = 'dcinfos';

    protected $fillable = ['portfolio_id', 'loan_id', 'name', 'number', 'expiration_date','cvv_code'];

    protected $encryption  = ['portfolio_id', 'loan_id', 'name', 'number', 'expiration_date','cvv_code'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    //setters
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = CreditCrypt::encryptString($value);
    }

    public function setExpirationDateAttribute($value)
    {
        $this->attributes['expiration_date'] = CreditCrypt::encryptString($value);
    }

    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = CreditCrypt::encrypt($value);
    }

    public function setCvvCodeAttribute($value)
    {
        $this->attributes['cvv_code'] = CreditCrypt::encrypt($value);
    }

    public function getCvvCodeAttribute($value)
    {
        return CreditCrypt::decrypt($value);
    }

    //getters
    public function getNameAttribute($value)
    { 
        // $tmp = CreditCrypt::decryptString($value);
        return CreditCrypt::decryptString($value);
    }

    public function getExpirationDateAttribute($value)
    {
        return CreditCrypt::decryptString($value);
    }

    public function getNumberAttribute($value)
    {       
        return CreditCrypt::decrypt($value);
    }   

    public static function setDc($request) 
    {
        $dcinfo = new DCInfo;
        $dcinfo->portfolio_id = $request->portfolio_id;
        $dcinfo->loan_id = $request->loan_id;
        $dcinfo->name = $request->name;
        $dcinfo->number = $request->number;
        $dcinfo->expiration_date = $request->expiration_date;
        $dcinfo->cvv_code = $request->cvv_code;
        $dcinfo->save();

        return $dcinfo;
    }

    public static function getDc()
    {
        $dcinfo = DCInfo::with(['portfolio'])->get();
        
        return $dcinfo;
    }

    
}
