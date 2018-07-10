<?php

namespace App\Http\Controllers;


use Illuminate\Console\Command;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Crypt;
use App\Encrypterdecrypter\SalarEncyptFacade as SalaryCrypt;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Vps\ {
    TaxStatuses,
    Addresses,
    Users,
    EmploymentType,
    OfficeLocation,
    Department,
    Designation,
    GovernmentIdentityNo,
    CostCenter,
    Salary
};



class TestCode extends Controller
{
   public function index ()
   {

       $exitCode = Artisan::call('execute:testcode');

//       $data = array(
//          array('username'=>'Coder 2', 'password'=> 2048, 'first_name'=>'Coder 1', 'last_name'=>'Coder 1', 'employee_number'=>'32', 'designation_id'=>'1',),
//           //...username
//       );

//       Model::insert($data); // Eloquent approach
       // Query Builder approach


//
//       Excel::filter('chunk')->load('public/masterlist/masterlist.xlsx')->chunk(200, function($results)
//       {
//
//               foreach ($results as $item => $row)
//               {
//                   echo "<pre>";
//                   print_r($item);
//                   print($row->employee_id. ' - FirstName '. $row->first_name);
//               }
//       });


//       echo "<pre>";
//       print_r($excelreader);
//
//       $encrypted_1 = Crypt::encryptString('Hello world.');
//
//       $decrypted_1 = Crypt::decryptString($encrypted_1);
//
//       echo 'encypt : '. $encrypted_1.'<br>';
//       echo 'encypt : '. $decrypted_1.'<br>';
//
//       echo '----------------------------';
//       $encrypted = SalaryCrypt::encrypt('Hello world.');
//echo  $encrypted.'<br>';
//       $decrypted = SalaryCrypt::decryptString($encrypted);
//echo $decrypted.'<br>';


   }


}
