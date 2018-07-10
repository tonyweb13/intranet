<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    protected $table = 'addresses';

    protected $fillable = ['current_address', 'permanent_address'];


    public  static function importAddAddress( int $user_id, $address ) : int
    {
        $import = new Addresses;
        $import->current_address = $address->temporary_address;
        $import->permanent_address = $address->permanent_address;
        $import->save();

        return $import->id;
    }

}
