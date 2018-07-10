<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use App\Models\HR\Gravity;

class GravityOffense extends Model
{
	protected $connection = 'hr';

    protected $table = 'nte_gravity_offenses';

    protected $fillable = ['fields','gravity_id', 'description'];

    public function gravity()
    {
        return $this->belongsTo(Gravity::class);
    }
}
