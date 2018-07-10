<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator, Input, Image, Carbon\Carbon, File, Storage;


class UserController extends Controller
{

    public function getLoginUser()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $userInfo = $user->with(['department', 'designation', 'employment_type', 'address','government_credential'])->first();
        return $userInfo;
    }

    public function scriptTags(Request $request)
    {
        $storage = Storage::put('public/script_tags', $request->file('image'));
        $url = Storage::url($storage);
        
        return asset('/').  $url;
    }

}
