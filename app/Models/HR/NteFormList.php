<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class NteFormList extends Model
{
	protected $connection = 'hr';

    protected $table = 'nte_form_lists';

    protected $fillable = ['name', 'description'];

    public function nteForm()
    {
        return $this->hasMany(Nte::class, 'id');
    }
}
