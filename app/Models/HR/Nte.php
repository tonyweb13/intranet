<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Vps\Department;
use App\Models\HR\NteFormList;

class Nte extends Model
{
    protected $connection = 'hr';

    protected $table = 'ntes';

    protected $fillable = ['employee_id','email','first_name','last_name','date','role','department'];

    public function getDateAttribute($date)
    {
        $tmp = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('F d, Y');

        return $tmp;
    }

    public function nteFormList()
    {
        return $this->belongsTo(NteFormList::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
