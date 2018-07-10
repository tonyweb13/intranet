<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;
use App\Encrypterdecrypter\SalarEncyptFacade as SalaryCrypt;

class Salary extends Model
{
    protected $table = 'salary';

    public  static function importSalary( int $user_id, $salary ) : int
    {
        $import = new Salary;
        $import->basic_salary = SalaryCrypt::encrypt(self::moneyStringConvert($salary->basic_salary));
        $import->deminimis = (float) self::moneyStringConvert($salary->deminimis);
        $import->attendance_bonus = (float) self::moneyStringConvert($salary->attendance_bonus);
        $import->save();

        return $import->id;
    }


    public static function moneyStringConvert($string)
    {
        $replace = array(',', ' ', '-' );
        return str_replace($replace, "", preg_replace("/[^0-9,.]/", "", $string)) ?? null;
    }
}
