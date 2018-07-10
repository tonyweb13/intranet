<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Vps\{
    UsersGroups,
    Portfolio
};

class ImportUsersGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Execute:ImportUsersGroups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Users Groups Execution';

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

        $excelreader = Excel::load('public/masterlist/Masterlist_UserGroups.xlsx', function($reader) {
        $reader->all();
        })->get();
        $bar = $this->output->createProgressBar(count($excelreader));

        foreach ($excelreader as $item => $row)
        {
            try {

                $insert_item =  array(
                    'employee_no'              =>      $row->employee_id,
                    'group_id'                 =>      '',
                    'teamlead_employee_no'     =>      $row->team_lead_employee_id,
                );                
                $insert_id = DB::table('users_groups')->insertGetId($insert_item);
                $portfolio_id = Portfolio::where('name', $row->portfolio)->first()->id;

                UsersGroups::where('id', $insert_id)
                    ->update(['portfolio_id' => $portfolio_id]);

            } catch(\Exception $x) {
    
                echo ' Error importing Users Groups Employee ID : '.$row->employee_id.' row : '.$item. ' ( '.$x->getMessage().' ) \/';
            }

            $bar->advance();
        }

        $bar->finish();

    }

}
