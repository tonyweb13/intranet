<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use App\Models\HR\NteCategory;
use App\Models\HR\Provision;
use App\Models\HR\Gravity;
use App\Models\HR\CorrectiveAction;

class Offense extends Model
{
	protected $connection = 'hr';

    protected $table = 'nte_offenses';

    protected $fillable = ['category_id', 'provision_id', 'gravity_id', 'corrective_action_id', 'offense'];

    public function category()
    {
        return $this->belongsTo(NteCategory::class);
    }

    public function provision()
    {
        return $this->belongsTo(Provision::class);
    }

    public function gravity()
    {
        return $this->belongsTo(Gravity::class);
    }

    public function corrective_action()
    {
        return $this->belongsTo(CorrectiveAction::class);
    }
}
