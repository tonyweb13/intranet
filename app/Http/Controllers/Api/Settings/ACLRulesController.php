<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Vps\AclRules;
use Illuminate\Http\Request;

class ACLRulesController extends Controller
{

    public function index()
    {
        $aclrules = AclRules::leftJoin('acl_rules as rule2', 'acl_rules.rule_parent_id', '=', 'rule2.id')
            ->select('acl_rules.id', 'acl_rules.rule_name', 'acl_rules.rule_parent_id', DB::raw("(CASE WHEN (acl_rules.is_enable = 1) THEN 'Yes' ELSE 'No' END) as is_enable"), 'acl_rules.label', 'acl_rules.description',
                DB::raw("(CASE WHEN (rule2.rule_name = NULL) THEN '' ELSE rule2.rule_name END) as rule_parent"))
            ->orderBy('id')
            ->get();
        return response()->json($aclrules);
    }

    public function create(Request $request)
    {
        $aclrules = new AclRules;
        $aclrules->rule_name = $request->rule_name;
        $aclrules->rule_parent_id = $request->rule_parent_id;
        $aclrules->is_enable = $request->is_enable;
        $aclrules->label = $request->label;
        $aclrules->description = $request->description;
        $aclrules->save();
        return $aclrules;
    }

    public function show(int $id, Request $request)
    {
        $aclrules = AclRules::updateOrCreate(['id' => $id], $request->all());
        return $aclrules;
    }

    public function edit(int $id)
    {
        $aclrules = AclRules::all()->where('id', $id)->first();
        return $aclrules;
    }

    public function destroy(int $id)
    {
        $aclrules = AclRules::findOrFail($id);
        $aclrules->delete();
        return response()->json($aclrules);
    }

    public function dropdown()
    {
        $aclrules = AclRules::select('id as value','rule_name as text')->get();
        return response()->json($aclrules);
    }
}
