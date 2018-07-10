<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Vps\{
    UsersGroups,
    Portfolio
};

class ImportPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Payment:Import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Payment Information to Database';

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

        DB::connection('loan')->table('payments_data')->truncate();
//
//        $query = sprintf("LOAD DATA LOCAL INFILE '%s'
//        INTO TABLE payments_data
//        FIELDS TERMINATED BY ','
//        IGNORE 1 LINES
// ", addslashes(storage_path('payment_files/payments_data.csv'));

        $query = "LOAD DATA LOCAL INFILE '".addslashes(public_path('storage/payment_files/payments_data.csv'))."'
        INTO TABLE payments_data
        FIELDS TERMINATED BY ','
        IGNORE 1 LINES
        (portfolio, payment_id, loan_number, identity, payment_line_type, line_number, @origination_date, @effective_date, p_1, nf, lt, ff, uff, p_2, a, mode, status1, rc, @r_d, new_id, note, status2, rr, is_makeup, @c_date, @end_date) 
        SET origination_date = STR_TO_DATE(@origination_date,'%m/%d/%Y'), effective_date = STR_TO_DATE(@effective_date,'%m/%d/%Y'), r_d = STR_TO_DATE(@r_d,'%m/%d/%Y'),  c_date = STR_TO_DATE(@c_date,'%m/%d/%Y'),  end_date = STR_TO_DATE(@end_date,'%m/%d/%Y')
        ";
//        echo $query;

        return DB::connection('loan')->getpdo()->exec($query);

//        $query = sprintf("LOAD DATA local INFILE '%s' INTO TABLE users
//        FIELDS TERMINATED BY ','
//        OPTIONALLY ENCLOSED BY '\"'
//        ESCAPED BY '\"'
//        LINES TERMINATED BY '\\n'
//        IGNORE 0 LINES (firstname, lastname, username, gender, email, country`, `ethnicity`, `education`  )",
//            addslashes($csv));

//        Excel::filter('chunk')->load('public/storage/payment_files/payments_data.xlsx')->chunk(1, function($results)
//        {
//            print_r($results);
//            foreach($results as $row)
//            {
//                $insert_item =  array(
//                    'payment_id'        =>      trim($row->paymentid),
//                    'loan_number'       =>      trim($row->loan_number),
//                    'payment_line_type' =>      trim($row->payment_line_type),
//                    'line_number'       =>      trim($row->line_number),
//                    'origination_date'  =>      trim($row->originationdate),
//                    'effective_date'    =>      trim($row->effective_date),
//                    'p_1'               =>      trim($row->p),
//                    'nf_1'              =>      trim($row->nf),
//                    'nf_2'              =>      trim($row->lt),
//                    'lt'                =>      trim($row->uff),
//                    'ff'                =>      trim($row->a),
//                    'uff'               =>      trim($row->mode),
//                );
//                $insert_id = DB::connection('loan')->table('payments_data')->insertGetId($insert_item);
//            }
//
//        });

//        $excelreader = Excel::filter('chunk')->load('public/storage/payment_files/payments_data.xlsx', function($reader) {
//        $reader->limitRows(1);
////        $reader->all();
//        })->get(1);
//        $bar = $this->output->createProgressBar(count($excelreader));

//        print_r($excelreader);
//        foreach ($excelreader as $item => $row)
//        {
//            try {
//
////                $insert_item =  array(
////                    'payment_id'        =>      trim($row->PaymentId),
//////                    'loan_number'       =>      trim(''),
//////                    'payment_line_type' =>      trim($row->team_lead_employee_id),
//////                    'line_number'       =>      trim($row->team_lead_employee_id),
//////                    'origination_date'  =>      trim($row->team_lead_employee_id),
//////                    'effective_date'    =>      trim($row->team_lead_employee_id),
//////                    'p_1'               =>      trim($row->team_lead_employee_id),
//////                    'nf_1'              =>      trim($row->team_lead_employee_id),
//////                    'nf_2'              =>      trim($row->team_lead_employee_id),
//////                    'lt'                =>      trim($row->team_lead_employee_id),
//////                    'ff'                =>      trim($row->team_lead_employee_id),
//////                    'uff'               =>      trim($row->team_lead_employee_id),
//////                    'p_2'               =>      trim($row->team_lead_employee_id),
//////                    'a'                 =>      trim($row->team_lead_employee_id),
//////                    'mode'              =>      trim($row->team_lead_employee_id),
////                );
//                $insert_id = DB::table('payments_data')->insertGetId($insert_item);
//
//            } catch(\Exception $x) {
//
//                echo ' Error importing Users Groups Employee ID : '.$row->employee_id.' row : '.$item. ' ( '.$x->getMessage().' ) \/';
//            }
//
//            $bar->advance();
//        }

//        $bar->finish();

    }

}
