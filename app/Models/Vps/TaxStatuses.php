<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class TaxStatuses extends Model
{
    protected $table = 'tax_statuses';

    protected $fillable = ['name'];

//    public static function importTaxId( string $taxStatus ) : int
//    {
//        $query = self::where('name', $taxStatus)->first();
//
//        if (count($query)) {
//            return $query->id;
//        } else {
//            $query->name = $taxStatus;
//            return $query->save();
//        }
//
//    }


}
