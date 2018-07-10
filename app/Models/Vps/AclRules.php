<?php

namespace App\Models\Vps;

use Illuminate\Database\Eloquent\Model;

class AclRules extends Model
{
    protected $table = 'acl_rules';

    protected $fillable = ['rule_name', 'rule_parent_id', 'is_enable', 'label'];

    public function childrens()
    {
        return $this->hasMany($this, 'rule_parent_id');
    }

}
