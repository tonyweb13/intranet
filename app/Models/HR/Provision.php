<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use App\Models\HR\NteCategory;

class Provision extends Model
{
	protected $connection = 'hr';

    protected $table = 'nte_provisions';

    protected $fillable = ['provision', 'category_id'];

    public function category()
    {
        return $this->belongsTo(NteCategory::class);
    }
}
