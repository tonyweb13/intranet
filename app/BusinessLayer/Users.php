<?php

namespace App\BusinessLayer;

use App\Models\Role;
use App\Models\User;
use App\Models\Vps\OfficeLocation;
use Auth;
use DB;

class Users
{
    public function allUsers(bool $is_active = false)
    {
        if ($is_active) {
            $results = User::select(DB::raw("CONCAT(last_name, ', ', first_name) AS full_name"), 'id',  'employee_no')
                ->orderBy('last_name')->get()->pluck('full_name', 'employee_no');
        } else {
            $results = User::select(DB::raw("CONCAT(last_name, ', ', first_name) AS full_name"), 'id', 'employee_no')
                ->where('is_active', true)->orderBy('last_name')
                ->get()->pluck('full_name', 'employee_no');
        }

        return $results;
    }

    public function activeSupervisor()
    {
        $results = User::whereHas('designation', function ($query) {
            $query->whereIn('designation_id', [6, 7, 8, 9, 14, 16, 17, 18]);
        })->where('is_active', true)
            ->select(DB::raw("CONCAT(last_name, ', ', first_name) AS full_name"), 'id', 'employee_no')
            ->orderBy('last_name')
            ->get()->pluck('full_name', 'employee_no');

        return $results;
    }

    public function officeLocation()
    {
        $results = OfficeLocation::all()->pluck('description', 'id');

        return $results;
    }

    public function createVSelectArray($data)
    {
        $users = [];
        foreach ($data->toArray() as $key => $value) {
            $user['text'] = $value;
            $user['value'] = $key;
            array_push($users, $user);
        }

        return $users;
    }

}