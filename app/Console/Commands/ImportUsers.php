<?php

namespace App\Console\Commands;

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
    Salary,
    Rules
};

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Execute:ImportUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Code execution';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

//    $user = Salary::whereId(1)->first();
//    print_r(SalaryCrypt::decryptString($user->basic_salary));
//    print_r(SalaryCrypt::decryptString($user->basic_salary));


//       $data = array(
//          array('username'=>'Coder 2', 'password'=> 2048, 'first_name'=>'Coder 1', 'last_name'=>'Coder 1', 'employee_number'=>'32', 'designation_id'=>'1',),
//           //...username
//       );

//       Model::insert($data); // Eloquent approach
        // Query Builder approach



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

        $excelreader = Excel::load('public/masterlist/arbmasterlistnew_with_cr.xlsx', function($reader) {
//           $first_raw = $reader->all();
//           $reader->remember(10)->get();
//             $reader->limitRows(1);
        $reader->all();


//           print_r($reader->getheading());
//           var_dump($reader->get()[0]->getHeading());
        })->get();
        $bar = $this->output->createProgressBar(count($excelreader));



//        echo Salary::moneyStringConvert('-');
//       print_r($excelreader);
//
        foreach ($excelreader as $item => $row)
        {
//            $this->performTask($row);
            try {

                if(Users::where('employee_no', $row->employee_id)->count() == 0 ) {
                    $insert_item =  array('username'=>'Coder 1',
                        'username'           => preg_replace('/[^A-Za-z0-9\-]/', '',strtolower($row->first_name.'.'.$row->last_name)),
                        'password'           => Hash::make('pass1234'),
                        'is_default_password'=> true,
                        'employee_no'        => $row->employee_id,
                        'first_name'         => $row->first_name,
                        'last_name'          => $row->last_name,
                        'middle_name'        => $row->middle_name,
                        'email_address'      => $row->email,
                        'birthday'           => $this->checkIsAValidDate($row->birthdate) ? Carbon::parse($row->birthdate) : null ,
                        'gender'             => $row->gender,
                        'tax_status_id'      => TaxStatuses::firstOrCreate(['name' => $row->tax_status ?? 'S' ])->id, //importTaxId($row->tax_status),
                        'civil_status'       => $row->civil_status,
                        'mobile_no'          => $row['mobile_no.'],
                        'employment_type_id' => EmploymentType::firstOrCreate(['name' => $row->employment_type])->id,
                        'work_location_id'   => OfficeLocation::firstOrCreate(['name' => $row->work_location])->id,
                        'date_hired'         => $this->checkIsAValidDate($row->start_date) ? Carbon::parse($row->start_date) : null,
                        'regularization_date'=> $this->checkIsAValidDate($row->regularization_date) ? Carbon::parse($row->regularization_date) : null,
                        'department_id'      => Department::firstOrCreate(['name' => $row->department])->id,
                        'designation_id'     => Designation::firstOrCreate(['name' => trim($row->position_title)])->id,
                        'educational_institution' => $row->educational_institution,
                        'course'             => $row->course,
                        'year_graduated'     => $row->year_graduated,
                        'bank_account_no'    => $row['bank_account_no.'],
                        'wave'               => $row->wave,
                        'person_to_contact_in_case_of_emergency' => $row->person_to_contact_in_case_of_emergency,
                        'contact_person_no'  => $row['contact_no.'],
                        'relationship'       => $row->relationship,
                        'cost_center_id'     => CostCenter::firstOrCreate(['name' => $row->cost_center])->id,
                    );

                    $insert_id = DB::table('users')->insertGetId($insert_item);

                    $address_id = Addresses::importAddAddress($insert_id, $row);
                    $identity_id = GovernmentIdentityNo::importIndentityNo($insert_id, $row);
                    $salary_id = Salary::importSalary($insert_id, $row);

                    DB::connection('vps')->table('rules')->insert(
                        ['user_id' => $insert_id, 'rules' => $this->rules(trim($row->position_title))]
                    );


                    Users::where('id', $insert_id)
                        ->update(['address_id' => $address_id, 'government_credential_id' => $identity_id, 'salary_id' => $salary_id]);


                } else {
                    echo  'Employee ID Already Exist : '.$row->employee_id;
                }

            } catch(\Exception $x) {

                echo 'Error importing Employee ID : '.$row->employee_id.' row : '.$item. ' ( '.$x->getMessage().' ) \/';
                exit;
            }

            $bar->advance();
        }

        $bar->finish();
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

    private function rules($designation)
    {
        $rule = '';
        switch ($designation) {
            case 'Loan Agent':
                $rule = '{"portfolios":{"is_enable":false,"child_rules":{"INBX":false,"SOF":false,"COMET":false,"IBC":false}},"loanapproval":{"is_enable":true,"child_rules":{"application_form":true,"application_list":{"is_enable":true,"child_rules":{"grab_app":false,"queue_app":true,"pending_app":true,"approved_app":true,"correction_app":true,"deny_app":true}},"application_action":{"is_enable":false,"child_rules":{"view_app":false,"reassign_app":false,"process_app":false,"update_app":false,"correction_app":false,"return_app":false,"deny_app":false,"approve_app":false}},"badaba":true,"adjustmentfinancefee":true,"uncrypted_cc":false,"dcinfo":true,"corrections":false,"reassignapp":false}},"hr":{"is_enable":false,"child_rules":{"nte":false,"nteform":false,"formlist":false,"provision":false,"gravity":false,"correctiveaction":false,"nteoffense":false}},"ticketing":{"is_enable":false,"child_rules":{"tracking":false}},"settings":{"is_enable":false,"child_rules":{"aclrules":false,"department":false,"designation":false,"costcenter":false,"officelocation":false,"employmenttype":false,"employees":false,"portfolios":false,"states":false,"usersgroups":false,"tags":false}},"script":{"is_enable":false,"child_rules":{"agentscript":false}},"tk":{"is_enable":false,"child_rules":{"workweek":false}},"qa":{"is_enable":false,"child_rules":{"dashboard":false,"form":{"is_enable":false,"child_rules":{"formlist":false,"auditstatus":false,"coachinglogs":false,"disputes":false,"clarification":false}},"qareports":{"is_enable":false,"child_rules":{"monthlyscore":false,"scoresummary":false,"generatesummary":false,"detailedreport":false,"statusreport":false}},"qasettings":{"is_enable":false,"child_rules":{"categories":false,"subcategories":false,"descriptions":false,"importemployee":false,"user":false}}}},"admin":{"is_enable":false,"child_rules":{"requestpayment":false,"requestpaymentcreate":false,"purchasingsupplies":false,"purchasingsuppliescreate":false}}}';
                break;
            case 'Programmer' :
            case 'Network Support' :
            case 'IT Helpdesk' :
            case 'IT Manager' :
                $rule = '{"portfolios":{"is_enable":true,"child_rules":{"INBX":true,"SOF":true,"COMET":true,"IBC":true}},"loanapproval":{"is_enable":true,"child_rules":{"application_form":true,"application_list":{"is_enable":true,"child_rules":{"grab_app":true,"queue_app":true,"pending_app":true,"approved_app":true,"correction_app":true,"deny_app":true}},"application_action":{"is_enable":true,"child_rules":{"view_app":true,"reassign_app":true,"process_app":true,"update_app":true,"correction_app":true,"return_app":true,"deny_app":true,"approve_app":true}},"badaba":true,"adjustmentfinancefee":true,"uncrypted_cc":true,"dcinfo":true,"corrections":true,"reassignapp":true}},"hr":{"is_enable":true,"child_rules":{"nte":true,"nteform":true,"formlist":true,"provision":true,"gravity":true,"correctiveaction":false,"nteoffense":false}},"ticketing":{"is_enable":true,"child_rules":{"tracking":true}},"settings":{"is_enable":true,"child_rules":{"aclrules":true,"department":true,"designation":true,"costcenter":true,"officelocation":true,"employmenttype":true,"employees":true,"portfolios":true,"states":true,"usersgroups":true,"tags":true}},"script":{"is_enable":true,"child_rules":{"agentscript":true}},"tk":{"is_enable":true,"child_rules":{"workweek":true}},"qa":{"is_enable":true,"child_rules":{"dashboard":true,"form":{"is_enable":true,"child_rules":{"formlist":true,"auditstatus":true,"coachinglogs":true,"disputes":true,"clarification":true}},"qareports":{"is_enable":true,"child_rules":{"monthlyscore":true,"scoresummary":true,"generatesummary":true,"detailedreport":true,"statusreport":true}},"qasettings":{"is_enable":true,"child_rules":{"categories":true,"subcategories":true,"descriptions":true,"importemployee":true,"user":true}}}},"admin":{"is_enable":true,"child_rules":{"requestpayment":false,"requestpaymentcreate":true,"purchasingsupplies":false,"purchasingsuppliescreate":true}}}';
                break;
            case 'Operations Director' :
            case 'Operation Supervisor' :
            case 'Operations Manager' :
                $rule = '{"portfolios":{"is_enable":false,"child_rules":{"INBX":false,"SOF":false,"COMET":false,"IBC":false}},"loanapproval":{"is_enable":true,"child_rules":{"application_form":true,"application_list":{"is_enable":true,"child_rules":{"grab_app":false,"queue_app":true,"pending_app":true,"approved_app":true,"correction_app":true,"deny_app":true}},"application_action":{"is_enable":true,"child_rules":{"view_app":false,"reassign_app":false,"process_app":false,"update_app":true,"correction_app":false,"return_app":false,"deny_app":false,"approve_app":false}},"badaba":true,"adjustmentfinancefee":true,"uncrypted_cc":false,"dcinfo":true,"corrections":false,"reassignapp":false}},"hr":{"is_enable":false,"child_rules":{"nte":false,"nteform":false,"formlist":false,"provision":false,"gravity":false,"correctiveaction":false,"nteoffense":false}},"ticketing":{"is_enable":false,"child_rules":{"tracking":false}},"settings":{"is_enable":false,"child_rules":{"aclrules":false,"department":false,"designation":false,"costcenter":false,"officelocation":false,"employmenttype":false,"employees":false,"portfolios":false,"states":false,"usersgroups":false,"tags":false}},"script":{"is_enable":false,"child_rules":{"agentscript":false}},"tk":{"is_enable":false,"child_rules":{"workweek":false}},"qa":{"is_enable":false,"child_rules":{"dashboard":false,"form":{"is_enable":false,"child_rules":{"formlist":false,"auditstatus":false,"coachinglogs":false,"disputes":false,"clarification":false}},"qareports":{"is_enable":false,"child_rules":{"monthlyscore":false,"scoresummary":false,"generatesummary":false,"detailedreport":false,"statusreport":false}},"qasettings":{"is_enable":false,"child_rules":{"categories":false,"subcategories":false,"descriptions":false,"importemployee":false,"user":false}}}},"admin":{"is_enable":false,"child_rules":{"requestpayment":false,"requestpaymentcreate":false,"purchasingsupplies":false,"purchasingsuppliescreate":false}}}';
                break;
            case 'Underwriter' :
            case 'Underwriting Specialist' :
                $rule = '{"portfolios":{"is_enable":true,"child_rules":{"INBX":true,"SOF":true,"COMET":true,"IBC":true}},"loanapproval":{"is_enable":true,"child_rules":{"application_form":true,"application_list":{"is_enable":true,"child_rules":{"grab_app":true,"queue_app":true,"pending_app":true,"approved_app":true,"correction_app":true,"deny_app":true}},"application_action":{"is_enable":true,"child_rules":{"view_app":true,"reassign_app":false,"process_app":true,"update_app":true,"correction_app":true,"return_app":true,"deny_app":true,"approve_app":true}},"badaba":true,"adjustmentfinancefee":true,"uncrypted_cc":true,"dcinfo":true,"corrections":false,"reassignapp":false}},"hr":{"is_enable":false,"child_rules":{"nte":false,"nteform":false,"formlist":false,"provision":false,"gravity":false,"correctiveaction":false,"nteoffense":false}},"ticketing":{"is_enable":false,"child_rules":{"tracking":false}},"settings":{"is_enable":false,"child_rules":{"aclrules":false,"department":false,"designation":false,"costcenter":false,"officelocation":false,"employmenttype":false,"employees":false,"portfolios":false,"states":false,"usersgroups":false,"tags":false}},"script":{"is_enable":false,"child_rules":{"agentscript":false}},"tk":{"is_enable":false,"child_rules":{"workweek":false}},"qa":{"is_enable":false,"child_rules":{"dashboard":false,"form":{"is_enable":false,"child_rules":{"formlist":false,"auditstatus":false,"coachinglogs":false,"disputes":false,"clarification":false}},"qareports":{"is_enable":false,"child_rules":{"monthlyscore":false,"scoresummary":false,"generatesummary":false,"detailedreport":false,"statusreport":false}},"qasettings":{"is_enable":false,"child_rules":{"categories":false,"subcategories":false,"descriptions":false,"importemployee":false,"user":false}}}},"admin":{"is_enable":false,"child_rules":{"requestpayment":false,"requestpaymentcreate":false,"purchasingsupplies":false,"purchasingsuppliescreate":false}}}';
                break;
            case 'Underwriting Supervisor' :
            case 'Underwriting Team Lead' :
                $rule = '{"portfolios":{"is_enable":true,"child_rules":{"INBX":true,"SOF":true,"COMET":true,"IBC":true}},"loanapproval":{"is_enable":true,"child_rules":{"application_form":true,"application_list":{"is_enable":true,"child_rules":{"grab_app":true,"queue_app":true,"pending_app":true,"approved_app":true,"correction_app":true,"deny_app":true}},"application_action":{"is_enable":true,"child_rules":{"view_app":true,"reassign_app":true,"process_app":true,"update_app":true,"correction_app":true,"return_app":true,"deny_app":true,"approve_app":true}},"badaba":true,"adjustmentfinancefee":true,"uncrypted_cc":true,"dcinfo":true,"corrections":false,"reassignapp":false}},"hr":{"is_enable":false,"child_rules":{"nte":false,"nteform":false,"formlist":false,"provision":false,"gravity":false,"correctiveaction":false,"nteoffense":false}},"ticketing":{"is_enable":false,"child_rules":{"tracking":false}},"settings":{"is_enable":false,"child_rules":{"aclrules":false,"department":false,"designation":false,"costcenter":false,"officelocation":false,"employmenttype":false,"employees":false,"portfolios":false,"states":false,"usersgroups":false,"tags":false}},"script":{"is_enable":false,"child_rules":{"agentscript":false}},"tk":{"is_enable":false,"child_rules":{"workweek":false}},"qa":{"is_enable":false,"child_rules":{"dashboard":false,"form":{"is_enable":false,"child_rules":{"formlist":false,"auditstatus":false,"coachinglogs":false,"disputes":false,"clarification":false}},"qareports":{"is_enable":false,"child_rules":{"monthlyscore":false,"scoresummary":false,"generatesummary":false,"detailedreport":false,"statusreport":false}},"qasettings":{"is_enable":false,"child_rules":{"categories":false,"subcategories":false,"descriptions":false,"importemployee":false,"user":false}}}},"admin":{"is_enable":false,"child_rules":{"requestpayment":false,"requestpaymentcreate":false,"purchasingsupplies":false,"purchasingsuppliescreate":false}}}';
                break;
            default :
                $rule = '{"portfolios":{"is_enable":false,"child_rules":{"INBX":false,"SOF":false,"COMET":false,"IBC":false}},"loanapproval":{"is_enable":true,"child_rules":{"application_form":true,"application_list":{"is_enable":true,"child_rules":{"grab_app":true,"queue_app":true,"pending_app":true,"approved_app":true,"correction_app":true,"deny_app":true}},"application_action":{"is_enable":false,"child_rules":{"view_app":false,"reassign_app":false,"process_app":false,"update_app":false,"correction_app":false,"return_app":false,"deny_app":false,"approve_app":false}},"badaba":true,"adjustmentfinancefee":true,"uncrypted_cc":true,"dcinfo":true,"corrections":false,"reassignapp":false}},"hr":{"is_enable":false,"child_rules":{"nte":false,"nteform":false,"formlist":false,"provision":false,"gravity":false,"correctiveaction":false,"nteoffense":false}},"ticketing":{"is_enable":false,"child_rules":{"tracking":false}},"settings":{"is_enable":false,"child_rules":{"aclrules":false,"department":false,"designation":false,"costcenter":false,"officelocation":false,"employmenttype":false,"employees":false,"portfolios":false,"states":false,"usersgroups":false,"tags":false}},"script":{"is_enable":false,"child_rules":{"agentscript":false}},"tk":{"is_enable":false,"child_rules":{"workweek":false}},"qa":{"is_enable":false,"child_rules":{"dashboard":false,"form":{"is_enable":false,"child_rules":{"formlist":false,"auditstatus":false,"coachinglogs":false,"disputes":false,"clarification":false}},"qareports":{"is_enable":false,"child_rules":{"monthlyscore":false,"scoresummary":false,"generatesummary":false,"detailedreport":false,"statusreport":false}},"qasettings":{"is_enable":false,"child_rules":{"categories":false,"subcategories":false,"descriptions":false,"importemployee":false,"user":false}}}},"admin":{"is_enable":false,"child_rules":{"requestpayment":false,"requestpaymentcreate":false,"purchasingsupplies":false,"purchasingsuppliescreate":false}}}';
                break;
        }

        return $rule;

    }
    private function checkIsAValidDate($myDateString) : bool
    {
        return strtotime($myDateString);
    }

}
