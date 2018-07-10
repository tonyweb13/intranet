<?php

namespace App\Http\Controllers\Api\Vps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Vps\Rules;
use App\Models\Vps\AclRules;
use Illuminate\Http\Request;
use App\Models\User;

class RulesController extends Controller
{

    public function index()
    {
        $rules = Rules::all();
        return response()->json($rules);
    }
    public function saveAclRulesBindToUser(Request $request)
    {
        $rules = [];
//        dd($request->rules);
        foreach ($request->rules as $acls) {
                if(count($acls['childrens']) >= 1) {
//                    print_r($acls['rule_name']);
//                    print_r($rules[$acls['rule_name']]);
                    $rules[$acls['rule_name']] = [];
//                    $rules[$acls['rule_name']]['is_enable'] = (bool) (isset($acls['in_usr_enable'])) ? $acls['in_usr_enable'] : false ;
                    $rules[$acls['rule_name']]['is_enable'] = $acls['in_usr_enable'] ?? false ;

                    foreach ($acls['childrens'] as $acl_child) {
//                        print_r($rules[$acls['rule_name']]);
//                        $rules[$acls['rule_name']]['is_enable'] = (bool) (isset($acls['in_usr_enable'])) ? $acls['in_usr_enable'] : false ;
                        $rules[$acls['rule_name']]['is_enable'] = $acls['in_usr_enable'] ?? false ;

                        if(count($acl_child['childrens']) >= 1) {

                            foreach ($acl_child['childrens'] as $acl_childs) {
//                                $rules[$acls['rule_name']]['child_rules'][$acl_child['rule_name']]['is_enable'] = (bool) (isset($acl_child['in_usr_enable'])) ? $acl_child['in_usr_enable'] : false ;
                                $rules[$acls['rule_name']]['child_rules'][$acl_child['rule_name']]['is_enable'] = $acl_child['in_usr_enable'] ?? false ;

//                                $rules[$acls['rule_name']]['child_rules'][$acl_child['rule_name']]['child_rules'][$acl_childs['rule_name']] = (isset($acl_childs['in_usr_enable'])) ? $acl_childs['in_usr_enable'] : false;
                                $rules[$acls['rule_name']]['child_rules'][$acl_child['rule_name']]['child_rules'][$acl_childs['rule_name']] = $acl_childs['in_usr_enable'] ?? false;
                            }

                        } else {
                            $rules[$acls['rule_name']]['child_rules'][$acl_child['rule_name']] = (bool) (isset($acl_child['in_usr_enable'])) ? $acl_child['in_usr_enable'] : false ;
                              $rules[$acls['rule_name']]['child_rules'][$acl_child['rule_name']] = $acl_child['in_usr_enable'] ?? false ;
                        }

                    }

                } else {
                    $rules[$acls['rule_name']] = (bool) $acls['in_usr_enable'];
                }
        }

//        dd($rules);

        $usr_acl_rules = Rules::updateOrCreate(
            ['user_id' => $request->empid], [ 'rules' => $rules]
        );

        return $usr_acl_rules;
    }

    public function getAclRulesBindToUser(Request $request)
    {
        $new_parent_rule = (object) [];

        $acl_rules = AclRules::with(['childrens' => function($query) {
            return $query->with('childrens');
        }])->where('rule_parent_id', '')->orWhereNull('rule_parent_id')->get();

        $user_rules = Rules::where('user_id', $request->empid)->first();

        foreach ($acl_rules as $acl => $value ) {

            $in_parent_usr_rule = false;

            if (isset($user_rules->rules[$value->rule_name])) {

                $parent_rules = $user_rules->rules[$value->rule_name];

                if (is_array($parent_rules) && count($parent_rules) >= 1) {

//                  $in_parent_usr_rule = (!isset($parent_rules['is_enable'])) ?: $parent_rules['is_enable'] ;
                    $in_parent_usr_rule = $parent_rules['is_enable'] ?? false ;

                    foreach ($value->childrens as $acl_child => $value_child) {

                        $in_child_usr_rule = false;

                        if (count($value_child->childrens) >= 1) {

//                          $in_child_usr_rule = (!isset($parent_rules['child_rules'][$value_child->rule_name]['is_enable'])) ?: $parent_rules['child_rules'][$value_child->rule_name]['is_enable'];
                            $in_child_usr_rule = $parent_rules['child_rules'][$value_child->rule_name]['is_enable'] ?? false;

                            $rules_3rd_child = (!isset($parent_rules['child_rules'][$value_child->rule_name])) ?: $parent_rules['child_rules'][$value_child->rule_name];

                            foreach ($value_child->childrens as $acl_3rd_child => $value_3rd_child) {

                                $new_3rd_child_usr_rule = false;

                                if(isset($rules_3rd_child['child_rules'][$value_3rd_child->rule_name])) {

                                    $new_3rd_child_usr_rule = $rules_3rd_child['child_rules'][$value_3rd_child->rule_name];

                                }

                                $value_3rd_child->in_usr_enable =  $new_3rd_child_usr_rule;

                            }

                        } else {

                            $in_child_usr_rule = (bool) $this->usrChildRule($value_child, (object) $parent_rules);

                        }

                        $value_child->in_usr_enable = $in_child_usr_rule;

                    }

                } else {

                    $in_parent_usr_rule = (bool) $parent_rules;

                }

            }


            $value->in_usr_enable = $in_parent_usr_rule;
        }

        echo $acl_rules->toJson();
    }

    private function usrChildRule($child_rule, $parent_rules) : bool
    {

        if(isset($parent_rules->child_rules[$child_rule->rule_name])) {

//            print_r($parent_rules->child_rules[$child_rule->rule_name]['is_enable']);
            return (bool) $parent_rules->child_rules[$child_rule->rule_name];

        }

        return false;
    }

    public function create(Request $request)
    {
        $rules = new Rules;
        $rules->user_id = $request->user_id;
        // $rules->rules = json_decode(stripslashes(json_encode($request->rules)), true);
        $rules->rules = $request->rules;
        $rules->save();
        return $rules;
    }

    public function show(int $id, Request $request)
    {
        $rules = Rules::updateOrCreate(['user_id' => $id], $request->all());
        return $rules;
    }

    public function edit(int $id)
    {

    }

    public function getParentChild()
    {
        $rules = AclRules::leftJoin('acl_rules as parent', 'acl_rules.rule_parent_id', '=', 'parent.id')
            ->select(DB::raw('parent.id as parent_id, parent.rule_name as parent_name, parent.rule_parent_id as parent_parent_id, parent.is_enable as parent_is_enable, parent.label as parent_label, parent.description as parent_description, acl_rules.*'))
            ->groupBy('parent_name')
            ->orderBy('parent_id', 'desc')
            ->get();
        return response()->json($rules);
    }

    public function getRuleParent(int $id)
    {
        $rules = AclRules::where('rule_parent_id',NULL)->get();
        foreach($rules as $rule){
            if($this->findSwitchOn($id, $rule->rule_name) > 0 ){
                $rules = AclRules::leftJoin('acl_rules as parent', 'acl_rules.id', '=', 'parent.id')
                ->select(DB::raw('COUNT(parent.rule_name) as parent_count, acl_rules.*'))
                ->groupBy('parent.id')->where('parent.rule_parent_id',NULL)->get();
            }  
        }

        return response()->json($rules);
    }

    public function getRuleChild(int $id)
    {

        $ruleChild = AclRules::where("rule_parent_id", '!=', NULL)->get();
         foreach($ruleChild as $rule){
            if($this->findSwitchOn($id, $rule->rule_name) > 0 ){
                $ruleChild = AclRules::leftJoin('acl_rules as parent', 'acl_rules.id', '=', 'parent.id')
                ->select(DB::raw('COUNT(parent.rule_name) as child_count, acl_rules.*'))
                ->groupBy('parent.id')->where("parent.rule_parent_id", '!=', NULL)->get();
            }  
        }
        return response()->json($ruleChild);
    }

    public function findChild(int $id)
    {

        $ruleChild = AclRules::where("rule_parent_id", $id)->get();
        return response()->json($ruleChild);

        // print_r($ids);
        // $ruleChild = AclRules::whereIn("rule_parent_id", $request)->get();
        // return response()->json($ruleChild);
    }

    public function findSwitchOn(int $id, string $string)
    {
        $switchOn = Rules::select("rules")->where('user_id', $id)->where("rules", 'like', '%'.$string.'%')->get();
        return count($switchOn);
    }

}
