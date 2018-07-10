<?php

namespace App\Http\Controllers\Api\Vps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator, Input, Image, Carbon\Carbon, File, Storage;
use App\Models\User;
use App\Models\Vps\{
    Addresses,
    GovernmentIdentityNo,
    UserUpdate
};


class UserUpdateController extends Controller
{

    public function updatePersonal(int $id, Request $request)
    {
        // $auth = Auth::user();
        // $user= $auth->where('id', $id)
        //     ->update(['gender' => $request->gender, 'birthday' => $request->birthday, 'civil_status' => $request->civil_status, 'mobile_no' => $request->mobile_no, 'email_address' => $request->email_address]);

        // if(!empty($request->current_address)){
        //     $address_id = $auth->address->id;
        //     $address = Addresses::findOrFail($address_id);
        //     $address->current_address = $request->current_address;
        //     $address->save();
        // }

        // return $user;

        $userid = UserUpdate::where('user_id', $id)->get();

        $current = [
                     'gender'=>$request->gender, 
                     'birthday'=>$request->birthday, 
                     'civil_status'=>$request->civil_status, 
                     'mobile_no'=>$request->mobile_no, 
                     'email_address'=>$request->email_address,
                     'current_address'=>$request->current_address
                 ];

        $change = UserUpdate::where('user_id', $id)->where('profile_edited', 'Personal')
                      ->update([ 'user_changes' => json_encode($current, JSON_FORCE_OBJECT) ]);

        if($change === 0){ //initial update

           $change = new UserUpdate;
           $change->user_id = $id;
           $change->profile_edited = 'Personal';
           $change->user_changes = json_encode($current, JSON_FORCE_OBJECT);
           $change->save(); 
        }         

        return $change;
    }

    public function updateEmployment(int $id, Request $request)
    {
        // $auth = Auth::user();
        // $employee= $auth->where('id', $id)
        //     ->update(['date_hired' => $request->date_hired, 'regularization_date' => $request->regularization_date, 'employment_type_id' => $request->employment_type_id]);

        // return $employee;

        $current = [
             'date_hired' => $request->date_hired,
             'regularization_date' => $request->regularization_date,
             'employment_type_id' => $request->employment_type_id
         ];

        $change = UserUpdate::where('user_id', $id)->where('profile_edited', 'Employment')
                      ->update([ 'user_changes' => json_encode($current, JSON_FORCE_OBJECT) ]);

        if($change === 0){ //initial update

           $change = new UserUpdate;
           $change->user_id = $id;
           $change->profile_edited = 'Employment';
           $change->user_changes = json_encode($current, JSON_FORCE_OBJECT);
           $change->save(); 
        }         

        return $change;
    }

    public function updateEducational(int $id, Request $request)
    {
        // $auth = Auth::user();
        // $educational= $auth->where('id', $id)
        //     ->update(['course' => $request->course, 'educational_institution' => $request->educational_institution, 'year_graduated' => $request->year_graduated]);

        // return $educational;

        $current = [
             'course' => $request->course,
             'educational_institution' => $request->educational_institution,
             'year_graduated' => $request->year_graduated
         ];

        $change = UserUpdate::where('user_id', $id)->where('profile_edited', 'Educational')
                      ->update([ 'user_changes' => json_encode($current, JSON_FORCE_OBJECT) ]);

        if($change === 0){ //initial update

           $change = new UserUpdate;
           $change->user_id = $id;
           $change->profile_edited = 'Educational';
           $change->user_changes = json_encode($current, JSON_FORCE_OBJECT);
           $change->save(); 
        }         

        return $change;
    }

    public function updateGovernment(int $id, Request $request)
    {
        // $auth = Auth::user();
        // $government= $auth->where('id', $id);

        // if(!empty($request->phil_health_number) || !empty($request->hmdf_number) || !empty($request->sss_number) || !empty($request->tin_number)){
        //     $government_id = $auth->address->id;
        //     $government = GovernmentIdentityNo::findOrFail($government_id);
        //     $government->phil_health_number = $request->phil_health_number;
        //     $government->hmdf_number = $request->hmdf_number;
        //     $government->sss_number = $request->sss_number;
        //     $government->tin_number = $request->tin_number;
        //     $government->save();
        // }

        // return $government;

        $current = [
             'phil_health_number' => $request->phil_health_number,
             'hmdf_number' => $request->hmdf_number,
             'sss_number' => $request->sss_number,
             'tin_number' => $request->tin_number
         ];

        $change = UserUpdate::where('user_id', $id)->where('profile_edited', 'Government')
                      ->update([ 'user_changes' => json_encode($current, JSON_FORCE_OBJECT) ]);

        if($change === 0){ //initial update

           $change = new UserUpdate;
           $change->user_id = $id;
           $change->profile_edited = 'Government';
           $change->user_changes = json_encode($current, JSON_FORCE_OBJECT);
           $change->save(); 
        }         

        return $change;
    }

    public function updateDetails(int $id, Request $request)
    {
        // $auth = Auth::user();
        // $details= $auth->where('id', $id)
        //     ->update(['person_to_contact_in_case_of_emergency' => $request->person_to_contact_in_case_of_emergency, 'relationship' => $request->relationship, 'contact_person_no' => $request->contact_person_no ]);

        // return $details;

        $current = [
            'person_to_contact_in_case_of_emergency' => $request->person_to_contact_in_case_of_emergency,
            'relationship' => $request->relationship,
            'contact_person_no' => $request->contact_person_no
        ];

        $change = UserUpdate::where('user_id', $id)->where('profile_edited', 'Details')
                      ->update([ 'user_changes' => json_encode($current, JSON_FORCE_OBJECT) ]);

        if($change === 0){ //initial update

           $change = new UserUpdate;
           $change->user_id = $id;
           $change->profile_edited = 'Details';
           $change->user_changes = json_encode($current, JSON_FORCE_OBJECT);
           $change->save(); 
        }         

        return $change;
    }

    public function uploadPic(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);
        } else {
            $save = $this->savePicture($request);
            return response()->json([
                'profile' => '/storage/profile/'.$save,
                'thumbnail' => '/storage/profile/thumbnail/'.$save,
                'file_name' => $save,
            ]);
            
//            $check_path = public_path().'/img/profile/';
//            $check_thumbnail = public_path().'/img/thumbnail/';

//            if (!file_exists($check_path) && !file_exists($check_thumbnail)) {
//
//                $thumb = File::makeDirectory($check_thumbnail , $mode  = 0777, true, true);
//                $path = File::makeDirectory($check_path , $mode  = 0777, true, true);
//                $save = $this->savePicture($request);
//                return response()->json([
//                    'profile' => 'https://s3-ap-southeast-2.amazonaws.com/vpssystem/vps/images/profile/'. $save,
//                    'thumbnail' => 'https://s3-ap-southeast-2.amazonaws.com/vpssystem/vps/images/profile/thumbnail/'. $save,
//                    'file_name' => $save,
//                ]);
//
//            } else {
//                $save = $this->savePicture($request);
//                return response()->json([
//                    'profile' => 'https://'. $save,
//                    'thumbnail' => '/img/thumbnail/'. $save,
//                    'file_name' => $save,
//                ]);
//            }
        }
    }

    public function savePicture($request) 
    {
        $imageData = $request->get('image');

            $exploded = explode(',', $imageData);

            $decoded = base64_decode($exploded[1]);

                if (str_contains($exploded[0], 'jpeg')) {
                    $extension ='jpg';
                } else {
                    $extension ='png';
                }

                $fileName = str_random(). '.' . $extension;

                $img = Image::make($decoded);
                $img->resize(48, 48);
                $img->stream();

                Storage::put('/vps/images/profile/'.$fileName, $img->__toString(), 'public');

                $thumb = public_path().'/img/thumbnail/'.$fileName;
//                file_put_contents($thumb, $decoded);
//              Storage::put('/vps/images/profile/thumbnail'.$fileName, $decoded);
//              $profile_thumb_url = Storage::get('/vps/images/profile/thumbnail'.$fileName);
                $thumb_img = Image::make($decoded);
                $thumb_img->fit(128, 128);
                $thumb_img->stream();
                Storage::put('/vps/images/profile/thumbnail/'.$fileName, $thumb_img->__toString(), 'public');

                $auth = Auth::user()->id;
                $image = User::where('id', $auth)
                ->update([ 'profile_pic' => $fileName]);

        return $fileName;
    }
}
