<?php

namespace App\Http\Controllers\Api\QualityAssurance;

use App\BusinessLayer\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDataController extends Controller
{
    public function allUser()
    {
        $users_data = new Users();
        $users_array = $users_data->allUsers(false);
        $results = $users_data->createVSelectArray($users_array);

        return response()->json($results);
    }

    public function activeUsers()
    {
        $users_data = new Users();
        $users_array = $users_data->allUsers(true);
        $results = $users_data->createVSelectArray($users_array);

        return response()->json($results);
    }

    public function activeSupervisor()
    {
        $users_data = new Users();
        $users_array = $users_data->activeSupervisor();
        $results = $users_data->createVSelectArray($users_array);

        return response()->json($results);
    }

    public function usersLocation()
    {
        $users_data = new Users();
        $offices = $users_data->officeLocation();
        $results = $users_data->createVSelectArray($offices);

        return response()->json($results);
    }
}
