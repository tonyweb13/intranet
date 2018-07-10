<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vps\{
    Users,
    UsersGroups   
};

class UsersGroupsController extends Controller
{
    public function portfolio(int $portfolio_id)
    {
        $groups = Users::with(['members.getUserInfo'])
            ->whereHas('members.getUserInfo', function($query) use ($portfolio_id) {
               $query->where('portfolio_id', $portfolio_id);
            })->get();
        return response()->json($groups);
    }

    public function updateUsersGroups(Request $request)
    {

        $groups = UsersGroups::where('employee_no', $request->employee_no)
        ->update(['teamlead_employee_no' => $request->teamlead_employee_no]);

        return $groups;
    }

    public function getTeamLead(int $portfolio_id, Request $request)
    {
         $groups = Users::with(['members.getUserInfo'])
            ->whereHas('members.getUserInfo', function($query) use ($portfolio_id) {
               $query->where('portfolio_id', $portfolio_id);
            })
            ->whereIn('employee_no', json_decode(stripslashes(json_encode($request->employee_no)), true))
            ->get(); 
           return response()->json($groups);
    }

}
